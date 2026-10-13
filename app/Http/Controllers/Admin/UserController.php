<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::with('role')->paginate(15);
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
            'phone' => 'nullable|string|max:30',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['email_verified_at'] = now();

        $user = User::create($validated);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'user.created',
            'auditable_type' => User::class,
            'auditable_id' => $user->id,
            'description' => "Menambahkan pengguna CMS baru: {$user->name} ({$user->email})",
        ]);

        return back()->with('success', "Pengguna {$user->name} berhasil ditambahkan.");
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email,'.$user->id,
            'role_id' => 'required|exists:roles,id',
            'phone' => 'nullable|string|max:30',
            'is_active' => 'nullable|boolean',
            'password' => 'nullable|string|min:8',
        ]);

        if (! empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['is_active'] = $request->boolean('is_active');

        $user->update($validated);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'user.updated',
            'auditable_type' => User::class,
            'auditable_id' => $user->id,
            'description' => "Memperbarui data pengguna: {$user->name}",
        ]);

        return back()->with('success', "Pengguna {$user->name} berhasil diperbarui.");
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $name = $user->name;
        $user->delete();

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'user.deleted',
            'auditable_type' => User::class,
            'auditable_id' => $user->id,
            'description' => "Menghapus pengguna: {$name}",
        ]);

        return back()->with('success', "Pengguna {$name} berhasil dihapus.");
    }
}
