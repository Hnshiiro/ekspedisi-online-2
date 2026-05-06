@extends('layouts.app')
@section('title','Dashboard Cabang')
@section('page-title','Dashboard Cabang: ' . ($branch->name ?? ''))
@section('breadcrumb','Dashboard')

@section('content')
<div class="stats-grid">
    @foreach([
        ['label'=>'Total Kiriman Cabang','value'=>$totalShipments,'icon'=>'fa-box','class'=>'orange'],
        ['label'=>'Menunggu Diproses','value'=>$pendingShipments,'icon'=>'fa-clock','class'=>'yellow'],
        ['label'=>'Dalam Perjalanan','value'=>$inTransitShipments,'icon'=>'fa-truck-moving','class'=>'blue'],
        ['label'=>'Selesai Terkirim','value'=>$deliveredShipments,'icon'=>'fa-check-circle','class'=>'green'],
    ] as $s)
    <div class="stat-card">
        <div class="stat-icon {{ $s['class'] }}"><i class="fa {{ $s['icon'] }}"></i></div>
        <div><div class="stat-value">{{ number_format($s['value']) }}</div><div class="stat-label">{{ $s['label'] }}</div></div>
    </div>
    @endforeach
</div>

<div style="display:grid;grid-template-columns:2fr 1fr;gap:1.5rem">
    <div class="table-card">
        <div class="table-card-header">
            <h3><i class="fa fa-clock-rotate-left" style="color:var(--primary)"></i> Kiriman Terbaru di Cabang Ini</h3>
            <a href="{{ route('branch.shipments.index') }}" class="btn btn-secondary btn-sm">Lihat Semua</a>
        </div>
        <div class="table-responsive">
            <table>
                <thead><tr><th>Resi</th><th>Tujuan</th><th>Layanan</th><th>Status</th><th style="width:200px">Aksi Tugas</th></tr></thead>
                <tbody>
                @forelse($recentShipments as $s)
                <tr>
                    <td><a href="{{ route('branch.shipments.show',$s) }}" style="font-weight:600;font-family:monospace;color:var(--primary)">{{ $s->tracking_number }}</a></td>
                    <td>{{ $s->destination_city }}</td>
                    <td>{{ $s->service?->name ?? '-' }}</td>
                    <td><span class="badge badge-{{ $s->status }}">{{ $s->status_label }}</span></td>
                    <td>
                        @if($s->status === 'pending')
                        <form action="{{ route('branch.shipments.assign', $s) }}" method="POST" style="display:flex;gap:.25rem">
                            @csrf
                            <select name="courier_id" class="form-control" style="font-size:.75rem;padding:.2rem;height:auto" required>
                                <option value="">Kurir</option>
                                @foreach($couriers as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
                            </select>
                            <select name="vehicle_id" class="form-control" style="font-size:.75rem;padding:.2rem;height:auto">
                                <option value="">Armada</option>
                                @foreach($vehicles as $v)<option value="{{ $v->id }}">{{ $v->plate_number }}</option>@endforeach
                            </select>
                            <button type="submit" class="btn btn-primary btn-sm" style="padding:.2rem .4rem" title="Tugaskan"><i class="fa fa-paper-plane"></i></button>
                        </form>
                        @else
                        <span style="font-size:.75rem;color:var(--gray-400)">{{ $s->courier->name ?? 'Belum ada kurir' }}</span>
                        @endif
                    </td>
                </tr>
                @empty<tr><td colspan="5" class="empty-state">Belum ada pengiriman</td></tr>@endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="table-card">
        <div class="table-card-header"><h3><i class="fa fa-truck" style="color:var(--primary)"></i> Armada Cabang</h3></div>
        <div style="padding:1rem">
            @forelse($vehicles as $v)
            <div style="display:flex;justify-content:space-between;align-items:center;padding:.75rem;background:var(--gray-50);border-radius:8px;margin-bottom:.5rem">
                <div>
                    <div style="font-family:monospace;font-weight:700;font-size:.9rem">{{ $v->plate_number }}</div>
                    <div style="font-size:.75rem;color:var(--gray-500);text-transform:capitalize">{{ $v->brand??'' }} · {{ $v->type }}</div>
                </div>
                <span class="badge badge-{{ $v->status }}">{{ ucwords(str_replace('_',' ',$v->status)) }}</span>
            </div>
            @empty<div class="empty-state" style="padding:1rem">Belum ada kendaraan</div>@endforelse
        </div>
    </div>
</div>
@endsection
