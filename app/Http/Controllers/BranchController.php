<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::withCount(['vehicles','shipments','users'])->orderBy('name')->paginate(15);
        return view('admin.branches.index', compact('branches'));
    }

    public function create()
    {
        return view('admin.branches.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code'      => 'required|string|max:50|unique:branches,code',
            'name'      => 'required|string|max:255',
            'city'      => 'required|string|max:100',
            'address'   => 'nullable|string',
            'phone'     => 'nullable|string|max:30',
            'email'     => 'nullable|email|max:255',
            'is_active' => 'boolean',
        ]);
        $validated['is_active'] = $request->boolean('is_active', true);
        Branch::create($validated);
        return redirect()->route('admin.branches.index')->with('success', 'Cabang berhasil ditambahkan.');
    }

    public function show(Branch $branch)
    {
        $branch->loadCount(['vehicles','shipments','users']);
        $branch->load(['vehicles','users']);
        return view('admin.branches.show', compact('branch'));
    }

    public function edit(Branch $branch)
    {
        return view('admin.branches.edit', compact('branch'));
    }

    public function update(Request $request, Branch $branch)
    {
        $validated = $request->validate([
            'code'      => 'required|string|max:50|unique:branches,code,'.$branch->id,
            'name'      => 'required|string|max:255',
            'city'      => 'required|string|max:100',
            'address'   => 'nullable|string',
            'phone'     => 'nullable|string|max:30',
            'email'     => 'nullable|email|max:255',
            'is_active' => 'boolean',
        ]);
        $validated['is_active'] = $request->boolean('is_active');
        $branch->update($validated);
        return redirect()->route('admin.branches.index')->with('success', 'Cabang berhasil diperbarui.');
    }

    public function destroy(Branch $branch)
    {
        if ($branch->shipments()->count() > 0) {
            return redirect()->route('admin.branches.index')
                ->with('error', 'Cabang tidak dapat dihapus karena memiliki data pengiriman.');
        }
        $branch->delete();
        return redirect()->route('admin.branches.index')->with('success', 'Cabang berhasil dihapus.');
    }

    public function toggleStatus(Branch $branch)
    {
        $branch->update(['is_active' => !$branch->is_active]);
        return back()->with('success', 'Status cabang ' . $branch->name . ' berhasil diubah menjadi ' . ($branch->is_active ? 'Aktif' : 'Non-aktif'));
    }
}
