@extends('layouts.app')
@section('title','Laporan')
@section('page-title','Laporan & Statistik')
@section('breadcrumb','Laporan')
@section('content')
<!-- Filter bar -->
<form action="" method="GET" style="display:flex;gap:.75rem;flex-wrap:wrap;margin-bottom:1.5rem;align-items:flex-end">
    <div>
        <label style="font-size:.8rem;font-weight:700;color:var(--gray-600);display:block;margin-bottom:.3rem">Bulan</label>
        <select name="month" class="form-control" style="padding:.5rem .8rem;width:140px">
            @foreach(range(1,12) as $m)
            <option value="{{ $m }}" {{ $month==$m?'selected':'' }}>{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label style="font-size:.8rem;font-weight:700;color:var(--gray-600);display:block;margin-bottom:.3rem">Tahun</label>
        <select name="year" class="form-control" style="padding:.5rem .8rem;width:100px">
            @foreach(range(now()->year, now()->year-3) as $y)
            <option value="{{ $y }}" {{ $year==$y?'selected':'' }}>{{ $y }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary"><i class="fa fa-filter"></i> Tampilkan</button>
</form>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem">
    <!-- Pengiriman by status -->
    <div class="table-card" style="padding:1.5rem">
        <h3 style="margin-bottom:1.2rem;font-size:1rem"><i class="fa fa-chart-pie" style="color:var(--primary)"></i> Status Pengiriman Bulan Ini</h3>
        @php $labels = \App\Models\Shipment::statusLabels() @endphp
        @forelse($shipmentsByStatus as $status => $total)
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.75rem">
            <div style="display:flex;align-items:center;gap:.5rem">
                <span class="badge badge-{{ $status }}">{{ $labels[$status]??$status }}</span>
            </div>
            <div style="display:flex;align-items:center;gap.75rem;gap:.75rem">
                <div style="width:100px;height:8px;background:var(--gray-100);border-radius:999px;overflow:hidden">
                    @php $max = max($shipmentsByStatus->values()->toArray() ?: [1]) @endphp
                    <div style="height:100%;background:var(--primary);border-radius:999px;width:{{ round($total/$max*100) }}%"></div>
                </div>
                <strong style="font-size:.875rem;min-width:24px;text-align:right">{{ $total }}</strong>
            </div>
        </div>
        @empty
        <p style="color:var(--gray-400);font-size:.875rem;text-align:center;padding:1rem">Belum ada data.</p>
        @endforelse
    </div>

    <!-- Revenue by month -->
    <div class="table-card" style="padding:1.5rem">
        <h3 style="margin-bottom:1.2rem;font-size:1rem"><i class="fa fa-chart-line" style="color:var(--primary)"></i> Pendapatan per Bulan ({{ $year }})</h3>
        @php $months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des']; $maxRev = max($revenueByMonth->values()->toArray() ?: [1]) @endphp
        @foreach($months as $mi => $mn)
        @php $rev = $revenueByMonth->get($mi+1, 0) @endphp
        <div style="display:flex;align-items:center;gap:.6rem;margin-bottom:.5rem">
            <div style="width:28px;font-size:.75rem;font-weight:600;color:var(--gray-500)">{{ $mn }}</div>
            <div style="flex:1;height:18px;background:var(--gray-100);border-radius:4px;overflow:hidden">
                <div style="height:100%;background:{{ $mi+1==$month?'var(--primary)':'var(--blue,#2673DD)' }};border-radius:4px;width:{{ $rev>0?round($rev/$maxRev*100):0 }}%;transition:width .4s"></div>
            </div>
            <div style="width:90px;font-size:.75rem;font-weight:700;text-align:right">Rp {{ number_format($rev,0,',','.') }}</div>
        </div>
        @endforeach
    </div>

    <!-- Top Branches -->
    <div class="table-card" style="padding:1.5rem;grid-column:1/-1">
        <h3 style="margin-bottom:1.2rem;font-size:1rem"><i class="fa fa-trophy" style="color:var(--primary)"></i> Top 5 Cabang Terbanyak Pengiriman</h3>
        <div class="table-responsive">
            <table>
                <thead><tr><th>Peringkat</th><th>Cabang</th><th>Kota</th><th>Total Pengiriman</th></tr></thead>
                <tbody>
                @forelse($topBranches as $i => $b)
                <tr>
                    <td>
                        <div style="width:28px;height:28px;border-radius:50%;background:{{ $i===0?'#fbbf24':($i===1?'#9ca3af':($i===2?'#cd7c2f':'var(--gray-200)')) }};color:{{ $i<3?'#fff':'var(--gray-600)' }};display:flex;align-items:center;justify-content:center;font-weight:800;font-size:.875rem">{{ $i+1 }}</div>
                    </td>
                    <td style="font-weight:600">{{ $b->name }}</td>
                    <td>{{ $b->city }}</td>
                    <td><span style="background:var(--orange-bg);color:var(--primary);padding:.3rem .75rem;border-radius:6px;font-weight:800">{{ $b->shipments_count }}</span></td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center;padding:1.5rem;color:var(--gray-400)">Belum ada data</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
