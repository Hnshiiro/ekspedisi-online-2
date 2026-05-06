@extends('layouts.app')
@section('title','Pengguna')
@section('page-title','Manajemen Pengguna')
@section('breadcrumb','Pengguna')
@section('content')
<div class="table-card">
    <div class="table-card-header">
        <h3><i class="fa fa-users" style="color:var(--primary)"></i> Daftar Pengguna Staff</h3>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah</a>
    </div>
    <form action="" method="GET" style="padding:.75rem 1.5rem;background:var(--gray-50);border-bottom:1px solid var(--gray-100);display:flex;gap:.75rem;flex-wrap:wrap">
        <select name="role" class="form-control" style="width:160px;padding:.5rem .8rem">
            <option value="">Semua Role</option>
            @foreach(['admin','branch_admin','courier','manager'] as $r)
            <option value="{{ $r }}" {{ request('role')===$r?'selected':'' }}>{{ ucwords(str_replace('_',' ',$r)) }}</option>
            @endforeach
        </select>
        <input type="text" name="search" class="form-control" placeholder="Cari nama/email..." value="{{ request('search') }}" style="max-width:240px;padding:.5rem .8rem">
        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Cari</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">Reset</a>
    </form>
    <div class="table-responsive">
        <table>
            <thead><tr><th>Nama</th><th>Email</th><th>Role</th><th>Cabang</th><th>Telepon</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($users as $u)
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:.6rem">
                        @if($u->photo)
                            <img src="{{ asset('storage/' . $u->photo) }}" style="width:32px;height:32px;border-radius:50%;object-fit:cover;flex-shrink:0">
                        @else
                            <div style="width:32px;height:32px;border-radius:50%;background:var(--primary);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.8rem;flex-shrink:0">{{ strtoupper(substr($u->name,0,1)) }}</div>
                        @endif
                        <span style="font-weight:600">{{ $u->name }}</span>
                    </div>
                </td>
                <td style="font-size:.875rem;color:var(--gray-600)">{{ $u->email }}</td>
                <td><span class="badge badge-{{ $u->role }}">{{ ucwords(str_replace('_',' ',$u->role)) }}</span></td>
                <td>{{ $u->branch?->name ?? '-' }}</td>
                <td>{{ $u->phone ?? '-' }}</td>
                <td><span class="badge {{ $u->is_active?'badge-active':'badge-inactive' }}">{{ $u->is_active?'Aktif':'Nonaktif' }}</span></td>
                <td style="display:flex;gap:.4rem;flex-wrap:wrap">
                    <a href="{{ route('admin.users.show',$u) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                    <a href="{{ route('admin.users.edit',$u) }}" class="btn btn-secondary btn-sm"><i class="fa fa-pen"></i></a>
                    @if($u->id !== auth()->guard('web')->id())
                    <form action="{{ route('admin.users.destroy',$u) }}" method="POST" onsubmit="return confirm('Hapus pengguna ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="7"><div class="empty-state"><i class="fa fa-users"></i><h3>Belum ada pengguna</h3></div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="pagination">{{ $users->links() }}</div>
    @endif
</div>
@endsection
