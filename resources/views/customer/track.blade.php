@extends('customer.dashboard')
@section('customer-content')
<div style="background:#fff;border-radius:16px;border:1px solid var(--gray-200);box-shadow:var(--shadow);overflow:hidden;padding:1.5rem">
    <h2 style="font-size:1.2rem;font-weight:800;margin-bottom:1.5rem"><i class="fa fa-magnifying-glass" style="color:var(--primary)"></i> Lacak Kiriman</h2>
    <form action="" method="GET" style="display:flex;gap:.5rem;margin-bottom:2rem">
        <input type="text" name="no" value="{{ $trackingNumber }}" placeholder="Masukkan No. Resi..." class="form-control" style="flex:1" required>
        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Lacak</button>
    </form>

    @if($trackingNumber && !$shipment)
        <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:1.5rem;text-align:center;color:#991b1b">Resi tidak ditemukan atau bukan milik Anda.</div>
    @elseif($shipment)
        <div style="border:1px solid var(--gray-200);border-radius:12px;padding:1.5rem">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:1.5rem;padding-bottom:1.5rem;border-bottom:1px solid var(--gray-100)">
                <div><div style="font-size:.85rem;color:var(--gray-500)">No. Resi</div><div style="font-size:1.4rem;font-weight:800;font-family:monospace;color:var(--primary)">{{ $shipment->tracking_number }}</div></div>
                <span class="status-badge status-{{ $shipment->status }}">{{ $shipment->status_label }}</span>
            </div>
            <h4 style="font-size:.95rem;font-weight:700;margin-bottom:1rem">Riwayat Perjalanan</h4>
            <div class="timeline">
                @forelse($shipment->trackings as $trk)
                <div class="timeline-item">
                    <div class="timeline-dot {{ $loop->first?'current':'active' }}"></div>
                    <div class="timeline-content" style="background:#fff;border:1px solid var(--gray-100)">
                        <strong style="color:var(--gray-900)">{{ \App\Models\Shipment::statusLabels()[$trk->status] ?? $trk->status }}</strong>
                        @if($trk->location) <span style="color:var(--gray-500);font-size:.8rem"> — {{ $trk->location }}</span> @endif
                        <small style="color:var(--gray-600);margin-top:.3rem">{{ $trk->description }}</small>
                        <small style="color:var(--gray-400);margin-top:.4rem">{{ $trk->checked_at->format('d M Y, H:i') }}</small>
                    </div>
                </div>
                @empty
                <p>Belum ada riwayat.</p>
                @endforelse
            </div>
        </div>
    @endif
</div>
@endsection
