@extends('layouts.app')
@section('title','Manager Dashboard')
@section('page-title','Dashboard Manajer')
@section('breadcrumb','Dashboard')

@section('content')
<div class="stats-grid">
    @foreach([
        ['label'=>'Pendapatan Bulan Ini','value'=>'Rp '.number_format($revenueMonth,0,',','.'),'icon'=>'fa-money-bill-wave','class'=>'green'],
        ['label'=>'Total Kiriman Selesai','value'=>number_format($shipmentsByStatus['delivered']??0),'icon'=>'fa-check-circle','class'=>'blue'],
        ['label'=>'Total Cabang Aktif','value'=>number_format($totalBranches),'icon'=>'fa-building','class'=>'purple'],
        ['label'=>'Total Pengguna/Staff','value'=>number_format($totalUsers),'icon'=>'fa-users','class'=>'orange'],
    ] as $s)
    <div class="stat-card">
        <div class="stat-icon {{ $s['class'] }}"><i class="fa {{ $s['icon'] }}"></i></div>
        <div><div class="stat-value" style="font-size:1.4rem">{{ $s['value'] }}</div><div class="stat-label">{{ $s['label'] }}</div></div>
    </div>
    @endforeach
</div>

<div style="display:grid;grid-template-columns:1fr;gap:1.5rem">
    <div class="table-card" style="padding:1.5rem">
        <div style="display:flex;justify-content:space-between;margin-bottom:1.2rem">
            <h3 style="font-size:1rem"><i class="fa fa-chart-pie" style="color:var(--primary)"></i> Sebaran Status Pengiriman Keseluruhan</h3>
            <a href="{{ route('manager.reports') }}" class="btn btn-primary btn-sm">Lihat Laporan Lengkap</a>
        </div>
        <div style="display:flex;flex-wrap:wrap;gap:1rem">
            @php $labels = \App\Models\Shipment::statusLabels() @endphp
            @foreach($shipmentsByStatus as $status => $total)
            <div style="flex:1;min-width:140px;background:var(--gray-50);border-radius:12px;padding:1.2rem;text-align:center;border:1px solid var(--gray-100)">
                <div style="font-size:2rem;font-weight:800;color:var(--primary);line-height:1;margin-bottom:.5rem">{{ number_format($total) }}</div>
                <div style="font-size:.8rem;font-weight:600;color:var(--gray-600)">{{ $labels[$status]??$status }}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
