<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(): View
    {
        $settings = Setting::all()->groupBy('group');

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $inputs = $request->except(['_token', '_method']);

        foreach ($inputs as $key => $val) {
            $existing = Setting::where('key', $key)->first();
            if ($existing) {
                Setting::set($key, $val, $existing->group, $existing->type, $existing->description);
            }
        }

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'settings.updated',
            'description' => 'Memperbarui konfigurasi sistem website.',
        ]);

        return back()->with('success', 'Pengaturan sistem berhasil disimpan.');
    }
}
