@extends('layouts.app')
@section('title','Cabang')
@section('page-title','Manajemen Cabang')
@section('breadcrumb','Cabang')
@section('content')
<div class="table-card">
    <div class="table-card-header">
        <h3><i class="fa fa-building" style="color:var(--primary)"></i> Daftar Cabang</h3>
        <a href="{{ route('admin.branches.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Cabang</a>
    </div>
    <div class="table-responsive">
        <table>
            <thead><tr><th>Kode</th><th>Nama Cabang</th><th>Kota</th><th>Telepon</th><th>Kendaraan</th><th>Pengiriman</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($branches as $b)
            <tr>
                <td><span style="font-family:monospace;font-weight:700">{{ $b->code }}</span></td>
                <td style="font-weight:600">{{ $b->name }}</td>
                <td>{{ $b->city }}</td>
                <td>{{ $b->phone ?? '-' }}</td>
                <td>{{ $b->vehicles_count ?? 0 }}</td>
                <td>{{ $b->shipments_count ?? 0 }}</td>
                <td><span class="badge {{ $b->is_active?'badge-active':'badge-inactive' }}">{{ $b->is_active?'Aktif':'Nonaktif' }}</span></td>
                <td style="display:flex;gap:.4rem;flex-wrap:wrap">
                    <a href="{{ route('admin.branches.show',$b) }}" class="btn btn-info btn-sm" title="Detail"><i class="fa fa-eye"></i></a>
                    <a href="{{ route('admin.branches.edit',$b) }}" class="btn btn-secondary btn-sm" title="Edit"><i class="fa fa-pen"></i></a>
                    <form action="{{ route('admin.branches.toggle',$b) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-{{ $b->is_active?'warning':'success' }} btn-sm" title="{{ $b->is_active?'Nonaktifkan':'Aktifkan' }}">
                            <i class="fa fa-{{ $b->is_active?'power-off':'check-circle' }}"></i>
                        </button>
                    </form>
                    <form action="{{ route('admin.branches.destroy',$b) }}" method="POST" onsubmit="return confirm('Hapus cabang ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus"><i class="fa fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="8"><div class="empty-state"><i class="fa fa-building"></i><h3>Belum ada cabang</h3></div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if(method_exists($branches,'links') && $branches->hasPages())
    <div class="pagination">{{ $branches->links() }}</div>
    @endif
</div>
@endsection
