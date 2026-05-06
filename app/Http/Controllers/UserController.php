<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('branch');
        if ($request->filled('role'))   $query->where('role', $request->role);
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(fn($sq) => $sq->where('name','like',"%$q%")->orWhere('email','like',"%$q%"));
        }
        $users = $query->orderBy('name')->paginate(15)->withQueryString();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $branches = Branch::where('is_active', true)->get();
        return view('admin.users.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'phone'     => 'nullable|string|max:30',
            'branch_id' => 'nullable|exists:branches,id',
            'role'      => 'required|in:admin,branch_admin,courier,manager',
            'password'  => 'required|string|min:6|confirmed',
            'is_active' => 'boolean',
        ]);
        $validated['is_active'] = $request->boolean('is_active', true);
        User::create($validated);
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        $user->load(['branch','assignedShipments']);
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $branches = Branch::where('is_active', true)->get();
        return view('admin.users.edit', compact('user','branches'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,'.$user->id,
            'phone'     => 'nullable|string|max:30',
            'branch_id' => 'nullable|exists:branches,id',
            'role'      => 'required|in:admin,branch_admin,courier,manager',
            'is_active' => 'boolean',
        ]);
        $validated['is_active'] = $request->boolean('is_active');
        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6|confirmed']);
            $validated['password'] = Hash::make($request->password);
        }
        $user->update($validated);
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->guard('web')->id()) {
            return redirect()->route('admin.users.index')->with('error', 'Tidak dapat menghapus akun sendiri.');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
