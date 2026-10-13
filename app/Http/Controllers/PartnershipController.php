<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\PartnershipLead;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class PartnershipController extends Controller
{
    public function index(): View
    {
        $page = Page::where('slug', 'partnership')->with('activeSections')->first();

        $seoOverride = [
            'title' => 'Kerja Sama Pengelolaan Villa & Properti - Ubu Hospitality',
            'description' => 'Tingkatkan okupansi dan pendapatan villa Anda di Yogyakarta bersama manajemen aset profesional Ubu Hospitality.',
        ];

        return view('partnership.index', compact('page', 'seoOverride'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'owner_name' => 'required|string|max:100',
            'company_name' => 'nullable|string|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'required|string|max:30',
            'property_name' => 'required|string|max:120',
            'property_type' => 'required|string|in:villa,glamping,resort,hotel,land,other',
            'property_address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'land_size_sqm' => 'nullable|integer|min:1|max:500000',
            'building_size_sqm' => 'nullable|integer|min:1|max:500000',
            'number_of_rooms' => 'nullable|integer|min:1|max:500',
            'partnership_model' => 'required|string|in:full_management,revenue_sharing,branding_only,consultation',
            'current_status' => 'required|string|in:ready_to_operate,under_construction,design_planning,land_only',
            'proposal_notes' => 'nullable|string|max:2000',
        ], [
            'owner_name.required' => 'Nama pemilik wajib diisi.',
            'email.required' => 'Email kontak wajib diisi.',
            'phone.required' => 'Nomor WhatsApp / telepon wajib diisi.',
            'property_name.required' => 'Nama properti wajib diisi.',
            'property_address.required' => 'Alamat lokasi properti wajib diisi.',
        ]);

        try {
            $referenceNo = DB::transaction(function () use ($validated, $request) {
                $ref = PartnershipLead::generateReferenceNo();

                $lead = PartnershipLead::create(array_merge($validated, [
                    'reference_no' => $ref,
                    'pipeline_status' => 'new',
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]));

                $lead->addStatusHistory('new', 'System', 'Pengajuan proposal kerja sama baru diterima via website.');
                $lead->save();

                return $ref;
            });

            return redirect()->route('partnership.index')
                ->with('success', "Terima kasih! Pengajuan properti Anda berhasil dikirim dengan Nomor Referensi: {$referenceNo}. Tim Business Development kami akan menghubungi Anda melalui WhatsApp / Email dalam waktu 1x24 jam kerja.")
                ->with('reference_no', $referenceNo);
        } catch (Exception $e) {
            Log::error('Error submitting partnership lead', ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kendala saat mengirim pengajuan. Silakan hubungi kami langsung via WhatsApp atau coba beberapa saat lagi.');
        }
    }
}
