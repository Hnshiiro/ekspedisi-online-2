<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::withCount(['sentShipments']);
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(fn($sq) => $sq->where('name','like',"%$q%")->orWhere('email','like',"%$q%")->orWhere('phone','like',"%$q%"));
        }
        $customers = $query->orderBy('name')->paginate(15)->withQueryString();
        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:customers,email',
            'phone'    => 'nullable|string|max:30',
            'address'  => 'nullable|string',
            'city'     => 'nullable|string|max:100',
            'password' => 'required|string|min:6|confirmed',
        ]);
        Customer::create($validated);
        return redirect()->route('admin.customers.index')->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function show(Customer $customer)
    {
        $customer->load(['sentShipments.service','receivedShipments.service']);
        return view('admin.customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:customers,email,'.$customer->id,
            'phone'   => 'nullable|string|max:30',
            'address' => 'nullable|string',
            'city'    => 'nullable|string|max:100',
        ]);
        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6|confirmed']);
            $validated['password'] = $request->password;
        }
        $customer->update($validated);
        return redirect()->route('admin.customers.index')->with('success', 'Pelanggan berhasil diperbarui.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('admin.customers.index')->with('success', 'Pelanggan berhasil dihapus.');
    }
}
