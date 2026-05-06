@extends('layouts.app')
@section('title','Pelanggan')
@section('page-title','Manajemen Pelanggan')
@section('breadcrumb','Pelanggan')
@section('content')
<div class="table-card">
    <div class="table-card-header">
        <h3><i class="fa fa-user-group" style="color:var(--primary)"></i> Daftar Pelanggan</h3>
        <a href="{{ route('admin.customers.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah</a>
    </div>
    <form action="" method="GET" style="padding:.75rem 1.5rem;background:var(--gray-50);border-bottom:1px solid var(--gray-100);display:flex;gap:.75rem">
        <input type="text" name="search" class="form-control" placeholder="Cari nama / email / telepon..." value="{{ request('search') }}" style="max-width:320px;padding:.5rem .8rem">
        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Cari</button>
        <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary btn-sm">Reset</a>
    </form>
    <div class="table-responsive">
        <table>
            <thead><tr><th>Nama</th><th>Email</th><th>Telepon</th><th>Kota</th><th>Total Kiriman</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($customers as $c)
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:.6rem">
                        @if($c->photo)
                            <img src="{{ asset('storage/' . $c->photo) }}" style="width:32px;height:32px;border-radius:50%;object-fit:cover;flex-shrink:0">
                        @else
                            <div style="width:32px;height:32px;border-radius:50%;background:var(--primary);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.8rem;flex-shrink:0">{{ strtoupper(substr($c->name,0,1)) }}</div>
                        @endif
                        <span style="font-weight:600">{{ $c->name }}</span>
                    </div>
                </td>
                <td style="color:var(--gray-600);font-size:.875rem">{{ $c->email }}</td>
                <td>{{ $c->phone ?? '-' }}</td>
                <td>{{ $c->city ?? '-' }}</td>
                <td><span style="background:var(--orange-bg);color:var(--primary);padding:.2rem .6rem;border-radius:6px;font-weight:700;font-size:.8rem">{{ $c->sent_shipments_count ?? 0 }}</span></td>
                <td style="display:flex;gap:.4rem">
                    <a href="{{ route('admin.customers.show',$c) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                    <a href="{{ route('admin.customers.edit',$c) }}" class="btn btn-secondary btn-sm"><i class="fa fa-pen"></i></a>
                    <form action="{{ route('admin.customers.destroy',$c) }}" method="POST" onsubmit="return confirm('Hapus pelanggan ini?')">
                        @csrf @method('DELETE')<button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6"><div class="empty-state"><i class="fa fa-users"></i><h3>Belum ada pelanggan</h3></div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($customers->hasPages())
    <div class="pagination">{{ $customers->links() }}</div>
    @endif
</div>
@endsection
