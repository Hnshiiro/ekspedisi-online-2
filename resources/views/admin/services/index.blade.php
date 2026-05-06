@extends('layouts.app')
@section('title','Layanan')
@section('page-title','Manajemen Layanan')
@section('breadcrumb','Layanan')
@section('content')
<div class="table-card">
    <div class="table-card-header">
        <h3><i class="fa fa-layer-group" style="color:var(--primary)"></i> Daftar Layanan</h3>
        <a href="{{ route('admin.services.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah</a>
    </div>
    <div class="table-responsive">
        <table>
            <thead><tr><th>Nama Layanan</th><th>Deskripsi</th><th>Multiplier Harga</th><th>Digunakan</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($services as $s)
            <tr>
                <td style="font-weight:700">{{ $s->name }}</td>
                <td style="color:var(--gray-600);font-size:.875rem">{{ $s->description ?? '-' }}</td>
                <td><span style="background:var(--orange-bg);color:var(--primary);padding:.3rem .75rem;border-radius:6px;font-weight:800">{{ $s->price_multiplier }}x</span></td>
                <td>{{ $s->shipments_count ?? 0 }} pengiriman</td>
                <td style="display:flex;gap:.4rem;flex-wrap:wrap">
                    <a href="{{ route('admin.services.edit',$s) }}" class="btn btn-secondary btn-sm"><i class="fa fa-pen"></i></a>
                    <form action="{{ route('admin.services.destroy',$s) }}" method="POST" onsubmit="return confirm('Hapus layanan ini?')">
                        @csrf @method('DELETE')<button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5"><div class="empty-state"><i class="fa fa-layer-group"></i><h3>Belum ada layanan</h3></div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
