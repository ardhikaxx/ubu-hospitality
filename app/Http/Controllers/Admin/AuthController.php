<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $remember = (bool) $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            if (! $user->is_active) {
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => 'Akun Anda berstatus nonaktif. Silakan hubungi Super Administrator.',
                ]);
            }

            $user->update(['last_login_at' => Carbon::now()]);

            AuditLog::create([
                'user_id' => $user->id,
                'action' => 'auth.login',
                'auditable_type' => User::class,
                'auditable_id' => $user->id,
                'description' => "Pengguna {$user->name} ({$user->email}) berhasil login ke CMS.",
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', "Selamat datang kembali, {$user->name}!");
        }

        throw ValidationException::withMessages([
            'email' => 'Kombinasi email atau kata sandi tidak cocok dengan data kami.',
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        if ($user = Auth::user()) {
            AuditLog::create([
                'user_id' => $user->id,
                'action' => 'auth.logout',
                'auditable_type' => User::class,
                'auditable_id' => $user->id,
                'description' => "Pengguna {$user->name} keluar dari CMS.",
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Anda telah berhasil keluar.');
    }

    public function showProfile(): View
    {
        $user = Auth::user();

        return view('admin.auth.profile', compact('user'));
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:30',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->phone = $validated['phone'];

        if (! empty($validated['new_password'])) {
            if (! Hash::check($validated['current_password'], $user->password)) {
                throw ValidationException::withMessages([
                    'current_password' => 'Kata sandi saat ini tidak sesuai.',
                ]);
            }
            $user->password = Hash::make($validated['new_password']);
        }

        $user->save();

        return back()->with('success', 'Profil dan akun berhasil diperbarui.');
    }
}
