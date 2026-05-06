@extends('layouts.app')
@section('title','Daftar Pengiriman')
@section('page-title','Manajemen Pengiriman')
@section('breadcrumb','Pengiriman')

@section('content')
<div class="table-card">
    <div class="table-card-header">
        <h3><i class="fa fa-box" style="color:var(--primary)"></i> Daftar Pengiriman</h3>
        @if(auth()->guard('web')->user()->role === 'admin')
        <a href="{{ route('admin.shipments.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Pengiriman</a>
        @endif
    </div>

    <!-- Filters -->
    <form action="" method="GET" style="padding:1rem 1.5rem;background:var(--gray-50);border-bottom:1px solid var(--gray-100);display:flex;gap:.75rem;flex-wrap:wrap;align-items:flex-end">
        <div>
            <label style="font-size:.75rem;font-weight:700;color:var(--gray-600);display:block;margin-bottom:.3rem">Status</label>
            <select name="status" class="form-control" style="min-width:140px;padding:.5rem .8rem">
                <option value="">Semua Status</option>
                @foreach(\App\Models\Shipment::statusLabels() as $val=>$label)
                <option value="{{ $val }}" {{ request('status')==$val?'selected':'' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        @if(auth()->guard('web')->user()->role === 'admin')
        <div>
            <label style="font-size:.75rem;font-weight:700;color:var(--gray-600);display:block;margin-bottom:.3rem">Cabang</label>
            <select name="branch_id" class="form-control" style="min-width:160px;padding:.5rem .8rem">
                <option value="">Semua Cabang</option>
                @foreach($branches as $b)<option value="{{ $b->id }}" {{ request('branch_id')==$b->id?'selected':'' }}>{{ $b->name }}</option>@endforeach
            </select>
        </div>
        @endif
        <div>
            <label style="font-size:.75rem;font-weight:700;color:var(--gray-600);display:block;margin-bottom:.3rem">Cari</label>
            <input type="text" name="search" class="form-control" placeholder="Resi / Nama pengirim..." value="{{ request('search') }}" style="min-width:200px;padding:.5rem .8rem">
        </div>
        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Filter</button>
        <a href="" class="btn btn-secondary btn-sm"><i class="fa fa-rotate"></i> Reset</a>
    </form>

    <div class="table-responsive">
        <table>
            <thead><tr><th>No. Resi</th><th>Pengirim</th><th>Penerima</th><th>Rute</th><th>Layanan</th><th>Berat</th><th>Harga</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($shipments as $s)
            <tr>
                <td><span style="font-family:monospace;font-size:.8rem;font-weight:600;color:var(--primary)">{{ $s->tracking_number }}</span></td>
                <td>{{ $s->sender_name ?? ($s->sender?->name ?? '-') }}</td>
                <td>{{ $s->receiver_name ?? ($s->receiver?->name ?? '-') }}</td>
                <td style="font-size:.8rem">{{ $s->origin_city }} → {{ $s->destination_city }}</td>
                <td>{{ $s->service?->name ?? '-' }}</td>
                <td>{{ number_format($s->total_weight,1) }} kg</td>
                <td style="font-weight:600">Rp {{ number_format($s->total_price,0,',','.') }}</td>
                <td>
                    <span class="badge badge-{{ $s->status }}">{{ $s->status_label }}</span>
                    <div style="margin-top:.2rem"><span class="badge badge-{{ $s->payment_status }}" style="font-size:.7rem">{{ ucfirst($s->payment_status) }}</span></div>
                </td>
                <td>
                    @php $route = auth()->guard('web')->user()->role === 'admin' ? route('admin.shipments.show',$s) : (auth()->guard('web')->user()->role === 'branch_admin' ? route('branch.shipments.show',$s) : route('manager.shipments.show',$s)) @endphp
                    <a href="{{ $route }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                </td>
            </tr>
            @empty
            <tr><td colspan="9"><div class="empty-state"><i class="fa fa-box-open"></i><h3>Belum ada pengiriman</h3><p>Belum ada data pengiriman yang tersedia.</p></div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @if($shipments->hasPages())
    <div class="pagination">
        @foreach($shipments->links()->elements[0] ?? [] as $page=>$url)
        <a href="{{ $url }}" class="page-link {{ $shipments->currentPage()==$page?'active':'' }}">{{ $page }}</a>
        @endforeach
    </div>
    @endif
</div>
@endsection
