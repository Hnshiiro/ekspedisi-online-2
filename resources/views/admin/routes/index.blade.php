@extends('layouts.app')
@section('title','Rute Pengiriman')
@section('page-title','Manajemen Rute')
@section('breadcrumb','Rute')
@section('content')
<div class="table-card">
    <div class="table-card-header">
        <h3><i class="fa fa-route" style="color:var(--primary)"></i> Daftar Rute Pengiriman</h3>
        <a href="{{ route('admin.routes.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Rute</a>
    </div>
    <div class="table-responsive">
        <table>
            <thead><tr><th>Asal</th><th>Tujuan</th><th>Harga/kg</th><th>Est. Hari</th><th>Digunakan</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($routes as $r)
            <tr>
                <td style="font-weight:600">{{ $r->origin_city }}</td>
                <td style="font-weight:600">{{ $r->destination_city }}</td>
                <td>Rp {{ number_format($r->price_per_kg,0,',','.') }}</td>
                <td>{{ $r->estimated_days }} hari</td>
                <td>{{ $r->shipments_count ?? 0 }}</td>
                <td style="display:flex;gap:.4rem;flex-wrap:wrap">
                    <a href="{{ route('admin.routes.edit',$r) }}" class="btn btn-secondary btn-sm"><i class="fa fa-pen"></i></a>
                    <form action="{{ route('admin.routes.destroy',$r) }}" method="POST" onsubmit="return confirm('Hapus rute ini?')">
                        @csrf @method('DELETE')<button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6"><div class="empty-state"><i class="fa fa-route"></i><h3>Belum ada rute</h3></div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
