<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminCourierController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('branch')->where('role', 'courier');
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(fn($sq) => $sq->where('name','like',"%$q%")->orWhere('email','like',"%$q%"));
        }
        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }
        
        $couriers = $query->orderBy('name')->paginate(15)->withQueryString();
        $branches = Branch::where('is_active', true)->get();
        
        return view('admin.couriers.index', compact('couriers', 'branches'));
    }

    public function create()
    {
        $branches = Branch::where('is_active', true)->get();
        return view('admin.couriers.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'phone'     => 'nullable|string|max:30',
            'branch_id' => 'required|exists:branches,id',
            'password'  => 'required|string|min:6|confirmed',
            'is_active' => 'boolean',
        ]);
        
        $validated['role'] = 'courier';
        $validated['is_active'] = $request->boolean('is_active', true);
        
        User::create($validated);
        return redirect()->route('admin.couriers.index')->with('success', 'Kurir berhasil ditambahkan.');
    }

    public function edit(User $courier)
    {
        if ($courier->role !== 'courier') abort(404);
        $branches = Branch::where('is_active', true)->get();
        return view('admin.couriers.edit', compact('courier', 'branches'));
    }

    public function update(Request $request, User $courier)
    {
        if ($courier->role !== 'courier') abort(404);
        
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,'.$courier->id,
            'phone'     => 'nullable|string|max:30',
            'branch_id' => 'required|exists:branches,id',
            'is_active' => 'boolean',
        ]);
        
        $validated['is_active'] = $request->boolean('is_active');
        
        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6|confirmed']);
            $validated['password'] = $request->password;
        }
        
        $courier->update($validated);
        return redirect()->route('admin.couriers.index')->with('success', 'Data kurir berhasil diperbarui.');
    }

    public function destroy(User $courier)
    {
        if ($courier->role !== 'courier') abort(404);
        
        if ($courier->assignedShipments()->count() > 0) {
            return redirect()->route('admin.couriers.index')->with('error', 'Tidak dapat menghapus kurir yang memiliki riwayat pengiriman.');
        }
        
        $courier->delete();
        return redirect()->route('admin.couriers.index')->with('success', 'Kurir berhasil dihapus.');
    }
}
