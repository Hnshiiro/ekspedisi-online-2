@extends('layouts.app')
@section('title','Kendaraan')
@section('page-title','Manajemen Kendaraan')
@section('breadcrumb','Kendaraan')
@section('content')
<div class="table-card">
    <div class="table-card-header">
        <h3><i class="fa fa-truck" style="color:var(--primary)"></i> Daftar Kendaraan</h3>
        @if(auth()->guard('web')->user()->role==='admin')
        <a href="{{ route('admin.vehicles.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah</a>
        @endif
    </div>
    <div class="table-responsive">
        <table>
            <thead><tr><th>Plat Nomor</th><th>Merek</th><th>Tipe</th><th>Kapasitas</th><th>Driver</th><th>Cabang</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($vehicles as $v)
            <tr>
                <td style="font-weight:700;font-family:monospace">{{ $v->plate_number }}</td>
                <td>{{ $v->brand ?? '-' }}</td>
                <td><span style="text-transform:capitalize">{{ $v->type }}</span></td>
                <td>{{ number_format($v->capacity_kg,0) }} kg</td>
                <td>{{ $v->driver_name ?? '-' }}</td>
                <td>{{ $v->branch?->name ?? '-' }}</td>
                <td><span class="badge badge-{{ $v->status }}">{{ ucwords(str_replace('_',' ',$v->status)) }}</span></td>
                <td style="display:flex;gap:.4rem;flex-wrap:wrap">
                    @if(auth()->guard('web')->user()->role==='admin')
                    <a href="{{ route('admin.vehicles.edit',$v) }}" class="btn btn-secondary btn-sm"><i class="fa fa-pen"></i></a>
                    <form action="{{ route('admin.vehicles.destroy',$v) }}" method="POST" onsubmit="return confirm('Hapus?')">
                        @csrf @method('DELETE')<button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="8"><div class="empty-state"><i class="fa fa-truck"></i><h3>Belum ada kendaraan</h3></div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
