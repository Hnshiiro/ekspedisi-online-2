@extends('layouts.app')
@section('title','Manajemen Kurir')
@section('page-title','Manajemen Kurir')
@section('breadcrumb','Kurir')
@section('content')
<div class="table-card">
    <div class="table-card-header">
        <h3><i class="fa fa-truck-ramp-box" style="color:var(--primary)"></i> Daftar Kurir</h3>
        <a href="{{ route('admin.couriers.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Kurir</a>
    </div>
    
    <div style="padding:1rem;background:var(--gray-50);border-bottom:1px solid var(--gray-100)">
        <form action="{{ route('admin.couriers.index') }}" method="GET" style="display:flex;gap:1rem;flex-wrap:wrap">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari nama atau email..." style="max-width:300px">
            <select name="branch_id" class="form-control" style="max-width:200px" onchange="this.form.submit()">
                <option value="">Semua Cabang</option>
                @foreach($branches as $b)
                <option value="{{ $b->id }}" {{ request('branch_id')==$b->id?'selected':'' }}>{{ $b->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-secondary">Filter</button>
        </form>
    </div>

    <div class="table-responsive">
        <table>
            <thead><tr><th>Nama Kurir</th><th>Email</th><th>Telepon</th><th>Cabang</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($couriers as $c)
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
                <td>{{ $c->email }}</td>
                <td>{{ $c->phone ?? '-' }}</td>
                <td><span class="badge badge-info">{{ $c->branch->name ?? 'Pusat' }}</span></td>
                <td><span class="badge {{ $c->is_active?'badge-active':'badge-inactive' }}">{{ $c->is_active?'Aktif':'Nonaktif' }}</span></td>
                <td style="display:flex;gap:.4rem">
                    <a href="{{ route('admin.couriers.edit',$c) }}" class="btn btn-secondary btn-sm"><i class="fa fa-pen"></i></a>
                    <form action="{{ route('admin.couriers.destroy',$c) }}" method="POST" onsubmit="return confirm('Hapus kurir ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6"><div class="empty-state"><h3>Belum ada kurir</h3></div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($couriers->hasPages())<div class="pagination">{{ $couriers->links() }}</div>@endif
</div>
@endsection
