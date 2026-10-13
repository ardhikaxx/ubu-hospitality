<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\PartnershipLead;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PartnershipController extends Controller
{
    public function index(Request $request): View
    {
        $query = PartnershipLead::query()->with('assignee')->latest('created_at');

        if ($request->filled('status')) {
            $query->where('pipeline_status', $request->status);
        }

        if ($request->filled('q')) {
            $search = '%'.$request->q.'%';
            $query->where(function ($q) use ($search) {
                $q->where('reference_no', 'like', $search)
                    ->orWhere('owner_name', 'like', $search)
                    ->orWhere('property_name', 'like', $search)
                    ->orWhere('phone', 'like', $search)
                    ->orWhere('email', 'like', $search);
            });
        }

        $leads = $query->paginate(15)->withQueryString();
        $statuses = ['new', 'contacted', 'survey_scheduled', 'under_review', 'negotiation', 'approved', 'rejected'];

        return view('admin.partnerships.index', compact('leads', 'statuses'));
    }

    public function show(PartnershipLead $lead): View
    {
        $users = User::where('is_active', true)->get();
        $statuses = ['new', 'contacted', 'survey_scheduled', 'under_review', 'negotiation', 'approved', 'rejected'];

        return view('admin.partnerships.show', compact('lead', 'users', 'statuses'));
    }

    public function updateStatus(Request $request, PartnershipLead $lead): RedirectResponse
    {
        $validated = $request->validate([
            'pipeline_status' => 'required|string|in:new,contacted,survey_scheduled,under_review,negotiation,approved,rejected',
            'status_note' => 'nullable|string|max:500',
        ]);

        $oldStatus = $lead->pipeline_status;
        $newStatus = $validated['pipeline_status'];

        $lead->addStatusHistory($newStatus, auth()->user()?->name, $validated['status_note'] ?? null);
        $lead->save();

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'partnership.status_changed',
            'auditable_type' => PartnershipLead::class,
            'auditable_id' => $lead->id,
            'description' => "Mengubah status prospek {$lead->reference_no} dari {$oldStatus} ke {$newStatus}",
            'old_values' => ['status' => $oldStatus],
            'new_values' => ['status' => $newStatus, 'note' => $validated['status_note'] ?? ''],
        ]);

        return back()->with('success', "Status prospek berhasil diubah menjadi {$newStatus}.");
    }

    public function updateNotes(Request $request, PartnershipLead $lead): RedirectResponse
    {
        $validated = $request->validate([
            'internal_notes' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $lead->update($validated);

        return back()->with('success', 'Catatan internal dan penanggung jawab berhasil diperbarui.');
    }

    public function export(Request $request): StreamedResponse
    {
        if (! auth()->user()?->hasPermission('partnerships.export')) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengekspor data prospek.');
        }

        $leads = PartnershipLead::latest()->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="prospek_kemitraan_'.date('Ymd_His').'.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $columns = [
            'No Referensi', 'Waktu Pengajuan', 'Nama Pemilik', 'Perusahaan', 'No WhatsApp',
            'Email', 'Nama Properti', 'Tipe', 'Kota', 'Alamat', 'Model Kemitraan',
            'Kesiapan Properti', 'Status Pipeline',
        ];

        $callback = function () use ($leads, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($leads as $l) {
                fputcsv($file, [
                    $l->reference_no,
                    $l->created_at->format('Y-m-d H:i'),
                    $l->owner_name,
                    $l->company_name,
                    $l->phone,
                    $l->email,
                    $l->property_name,
                    $l->property_type,
                    $l->city,
                    $l->property_address,
                    $l->partnership_model,
                    $l->current_status,
                    $l->pipeline_status,
                ]);
            }

            fclose($file);
        };

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'partnership.exported',
            'auditable_type' => PartnershipLead::class,
            'description' => 'Mengekspor data prospek kemitraan ke CSV.',
        ]);

        return response()->stream($callback, 200, $headers);
    }
}
