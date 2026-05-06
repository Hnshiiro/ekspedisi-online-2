@extends('layouts.app')
@section('title','Admin Dashboard')
@section('page-title','Dashboard Admin')
@section('breadcrumb','Dashboard')

@section('content')
<div class="stats-grid">
    @foreach([
        ['label'=>'Total Cabang','value'=>$totalBranches,'icon'=>'fa-building','class'=>'blue'],
        ['label'=>'Total Pelanggan','value'=>$totalCustomers,'icon'=>'fa-user-group','class'=>'purple'],
        ['label'=>'Total Kendaraan','value'=>$totalVehicles,'icon'=>'fa-truck','class'=>'teal'],
        ['label'=>'Total Pengguna','value'=>$totalUsers,'icon'=>'fa-users','class'=>'orange'],
        ['label'=>'Total Pengiriman','value'=>$totalShipments,'icon'=>'fa-box','class'=>'orange'],
        ['label'=>'Menunggu','value'=>$pendingShipments,'icon'=>'fa-clock','class'=>'yellow'],
        ['label'=>'Dalam Proses','value'=>$inTransitShipments,'icon'=>'fa-truck-moving','class'=>'blue'],
        ['label'=>'Total Kiriman Selesai','value'=>$deliveredShipments,'icon'=>'fa-check-double','class'=>'green'],
        ['label'=>'Cabang Aktif','value'=>\App\Models\Branch::where('is_active', true)->count(),'icon'=>'fa-building-circle-check','class'=>'blue'],
    ] as $s)
    <div class="stat-card">
        <div class="stat-icon {{ $s['class'] }}"><i class="fa {{ $s['icon'] }}"></i></div>
        <div><div class="stat-value">{{ number_format($s['value']) }}</div><div class="stat-label">{{ $s['label'] }}</div></div>
    </div>
    @endforeach
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:1.5rem">
    <!-- Revenue Card -->
    <div class="stat-card" style="grid-column:1/-1;background:linear-gradient(135deg,var(--primary),var(--primary-dark));border:none">
        <div class="stat-icon" style="background:rgba(255,255,255,.2)"><i class="fa fa-money-bill-wave" style="color:#fff"></i></div>
        <div>
            <div class="stat-value" style="color:#fff">Rp {{ number_format($totalRevenue,0,',','.') }}</div>
            <div class="stat-label" style="color:rgba(255,255,255,.8)">Total Pendapatan (Pembayaran Lunas)</div>
        </div>
    </div>
</div>

<div style="display:grid;grid-template-columns:2fr 1fr;gap:1.5rem">
    <!-- Recent Shipments -->
    <div class="table-card">
        <div class="table-card-header">
            <h3><i class="fa fa-box" style="color:var(--primary)"></i> Pengiriman Terbaru</h3>
            <a href="{{ route('admin.shipments.index') }}" class="btn btn-secondary btn-sm">Lihat Semua</a>
        </div>
        <div class="table-responsive">
            <table>
                <thead><tr><th>Resi</th><th>Pengirim</th><th>Tujuan</th><th>Layanan</th><th>Status</th></tr></thead>
                <tbody>
                @forelse($recentShipments as $s)
                <tr>
                    <td><a href="{{ route('admin.shipments.show',$s) }}" style="font-weight:600;color:var(--primary);font-family:monospace;font-size:.8rem">{{ $s->tracking_number }}</a></td>
                    <td>{{ $s->sender_name ?? ($s->sender?->name ?? '-') }}</td>
                    <td>{{ $s->destination_city }}</td>
                    <td>{{ $s->service?->name ?? '-' }}</td>
                    <td><span class="badge badge-{{ $s->status }}">{{ $s->status_label }}</span></td>
                </tr>
                @empty
                <tr><td colspan="5" class="empty-state" style="padding:2rem;text-align:center;color:var(--gray-400)">Belum ada pengiriman</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Payments -->
    <div class="table-card">
        <div class="table-card-header">
            <h3><i class="fa fa-credit-card" style="color:var(--primary)"></i> Pembayaran</h3>
            <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary btn-sm">Semua</a>
        </div>
        <div style="padding:1rem">
            @forelse($recentPayments as $p)
            <div style="padding:.75rem;border-radius:8px;background:var(--gray-50);margin-bottom:.5rem;display:flex;justify-content:space-between;align-items:center">
                <div>
                    <div style="font-size:.78rem;font-weight:600;font-family:monospace">{{ $p->payment_number }}</div>
                    <div style="font-size:.75rem;color:var(--gray-400)">{{ optional($p->payment_date)->format('d M Y') }}</div>
                </div>
                <div style="font-weight:700;font-size:.875rem;color:var(--success)">Rp {{ number_format($p->amount,0,',','.') }}</div>
            </div>
            @empty
            <div style="text-align:center;padding:1.5rem;color:var(--gray-400);font-size:.875rem">Belum ada pembayaran</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
