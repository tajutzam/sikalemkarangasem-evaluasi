<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index()
    {
        if (!Auth::user()->is_admin) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini!');
        }

        $users = User::with('instansi')->orderBy('name')->paginate(10);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        if (!Auth::user()->is_admin) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini!');
        }

        $instansis = \App\Models\Instansi::orderBy('nama_instansi')->get();
        return view('users.form', ['user' => null, 'instansis' => $instansis]);
    }

    public function store(Request $request)
    {
        if (!Auth::user()->is_admin) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini!');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)],
            'is_admin' => 'required|boolean',
            'username' => 'required',
            'instansi_id' => 'nullable|exists:instansi,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'is_admin' => $request->is_admin,
            'instansi_id' => $request->is_admin ? null : $request->instansi_id,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil ditambahkan!');
    }

    public function edit(User $user)
    {
        if (!Auth::user()->is_admin) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini!');
        }

        $instansis = \App\Models\Instansi::orderBy('nama_instansi')->get();
        return view('users.form', compact('user', 'instansis'));
    }

    public function update(Request $request, User $user)
    {
        if (!Auth::user()->is_admin) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini!');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => ['nullable', 'confirmed', Password::min(8)],
            'is_admin' => 'required|boolean',
            'username' => 'required',
            'instansi_id' => 'nullable|exists:instansi,id',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'is_admin' => $request->is_admin,
            'username' => $request->username,
            'instansi_id' => $request->is_admin ? null : $request->instansi_id,
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil diupdate!');
    }

    public function destroy(User $user)
    {
        if (!Auth::user()->is_admin) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini!');
        }

        // Prevent deleting own account
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri!');
        }

        // Prevent deleting user with evaluations
        if ($user->evaluations()->count() > 0) {
            return back()->with('error', 'User tidak dapat dihapus karena memiliki data evaluasi!');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus!');
    }
}
