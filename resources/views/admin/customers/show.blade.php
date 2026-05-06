@extends('layouts.app')
@section('title','Detail Pelanggan')
@section('page-title','Detail Pelanggan')
@section('content')
<div style="display:grid;grid-template-columns:1fr 2fr;gap:1.5rem;align-items:start">
    <div class="table-card" style="padding:1.5rem">
        <div style="text-align:center;margin-bottom:1.2rem">
            <div style="width:64px;height:64px;border-radius:50%;background:var(--primary);color:#fff;font-size:1.5rem;font-weight:800;display:flex;align-items:center;justify-content:center;margin:0 auto .75rem">{{ strtoupper(substr($customer->name,0,1)) }}</div>
            <h3 style="font-size:1.1rem;font-weight:700">{{ $customer->name }}</h3>
        </div>
        @foreach([['Email',$customer->email],['Telepon',$customer->phone??'-'],['Kota',$customer->city??'-'],['Alamat',$customer->address??'-'],['Bergabung',optional($customer->created_at)->format('d M Y')]] as [$l,$v])
        <div style="display:flex;justify-content:space-between;padding:.55rem 0;border-bottom:1px solid var(--gray-100);font-size:.85rem"><span style="color:var(--gray-500)">{{ $l }}</span><span style="font-weight:600;text-align:right;max-width:200px">{{ $v }}</span></div>
        @endforeach
        <div style="margin-top:1rem;display:flex;gap:.5rem">
            <a href="{{ route('admin.customers.edit',$customer) }}" class="btn btn-secondary btn-sm"><i class="fa fa-pen"></i> Edit</a>
            <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i></a>
        </div>
    </div>
    <div class="table-card">
        <div class="table-card-header"><h3><i class="fa fa-box"></i> Riwayat Pengiriman</h3></div>
        <div class="table-responsive">
            <table>
                <thead><tr><th>Resi</th><th>Tujuan</th><th>Layanan</th><th>Status</th><th>Harga</th></tr></thead>
                <tbody>
                @forelse($customer->sentShipments->merge($customer->receivedShipments)->sortByDesc('created_at')->take(20) as $s)
                <tr>
                    <td><span style="font-family:monospace;font-size:.78rem;color:var(--primary)">{{ $s->tracking_number }}</span></td>
                    <td>{{ $s->destination_city }}</td>
                    <td>{{ $s->service?->name??'-' }}</td>
                    <td><span class="badge badge-{{ $s->status }}">{{ $s->status_label }}</span></td>
                    <td style="font-weight:600">Rp {{ number_format($s->total_price,0,',','.') }}</td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center;padding:2rem;color:var(--gray-400)">Belum ada pengiriman</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
