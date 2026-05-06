@extends('layouts.app')
@section('title','Pembayaran')
@section('page-title','Manajemen Pembayaran')
@section('breadcrumb','Pembayaran')
@section('content')
<div class="table-card">
    <div class="table-card-header">
        <h3><i class="fa fa-credit-card" style="color:var(--primary)"></i> Daftar Pembayaran</h3>
        <a href="{{ route('admin.payments.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Pembayaran</a>
    </div>
    <form action="" method="GET" style="padding:.75rem 1.5rem;background:var(--gray-50);border-bottom:1px solid var(--gray-100);display:flex;gap:.75rem;flex-wrap:wrap">
        <select name="payment_status" class="form-control" style="width:160px;padding:.5rem .8rem">
            <option value="">Semua Status</option>
            @foreach(['pending','paid','failed'] as $s)
            <option value="{{ $s }}" {{ request('payment_status')===$s?'selected':'' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <input type="text" name="search" class="form-control" placeholder="No. Pembayaran / Resi..." value="{{ request('search') }}" style="max-width:260px;padding:.5rem .8rem">
        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i></button>
        <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary btn-sm">Reset</a>
    </form>
    <div class="table-responsive">
        <table>
            <thead><tr><th>No. Pembayaran</th><th>Resi</th><th>Pengirim</th><th>Jumlah</th><th>Metode</th><th>Tanggal</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($payments as $p)
            <tr>
                <td><span style="font-family:monospace;font-size:.8rem;font-weight:600">{{ $p->payment_number }}</span></td>
                <td><span style="font-family:monospace;font-size:.75rem;color:var(--primary)">{{ $p->shipment?->tracking_number??'-' }}</span></td>
                <td>{{ $p->shipment?->sender_name ?? $p->shipment?->sender?->name ?? '-' }}</td>
                <td style="font-weight:700;color:var(--success)">Rp {{ number_format($p->amount,0,',','.') }}</td>
                <td>{{ ucwords(str_replace('_',' ',$p->payment_method)) }}</td>
                <td>{{ optional($p->payment_date)->format('d M Y')??'-' }}</td>
                <td><span class="badge badge-{{ $p->payment_status }}">{{ ucfirst($p->payment_status) }}</span></td>
                <td><a href="{{ route('admin.payments.show',$p) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a></td>
            </tr>
            @empty
            <tr><td colspan="8"><div class="empty-state"><i class="fa fa-credit-card"></i><h3>Belum ada pembayaran</h3></div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($payments->hasPages())
    <div class="pagination">{{ $payments->links() }}</div>
    @endif
</div>
@endsection
