@extends('layouts.landing')
@section('title','Lacak Paket')
@section('content')
<div style="background:var(--gray-50);min-height:80vh;padding:4rem 1.5rem">
    <div style="max-width:800px;margin:0 auto">
        <h1 style="font-size:2rem;font-weight:800;text-align:center;margin-bottom:2rem;color:var(--gray-900)">Lacak Paket Anda</h1>

        <div style="background:#fff;border-radius:16px;padding:2rem;box-shadow:var(--shadow-lg);margin-bottom:2rem">
            <form action="{{ route('tracking') }}" method="GET" style="display:flex;gap:1rem">
                <input type="text" name="no" value="{{ $trackingNumber }}" class="form-control" placeholder="Masukkan nomor resi..." required style="flex:1;padding:1rem;font-size:1.1rem">
                <button type="submit" class="btn btn-primary" style="padding:0 2rem;font-size:1.1rem;font-weight:700"><i class="fa fa-search"></i> Lacak</button>
            </form>
        </div>

        @if($trackingNumber && !$trackedShipment)
            <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:12px;padding:1.5rem;text-align:center;color:#991b1b">
                <i class="fa fa-circle-xmark" style="font-size:2rem;margin-bottom:.5rem"></i>
                <p>Nomor resi <strong>{{ $trackingNumber }}</strong> tidak ditemukan dalam sistem kami.</p>
            </div>
        @elseif($trackedShipment)
            <div style="background:#fff;border-radius:16px;padding:2rem;box-shadow:var(--shadow-lg)">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:2rem;padding-bottom:1.5rem;border-bottom:1px solid var(--gray-100)">
                    <div>
                        <div style="font-size:.9rem;color:var(--gray-500);margin-bottom:.3rem">No. Resi</div>
                        <div style="font-size:1.6rem;font-weight:800;font-family:monospace;color:var(--primary)">{{ $trackedShipment->tracking_number }}</div>
                    </div>
                    <span class="status-badge status-{{ $trackedShipment->status }}" style="font-size:1rem;padding:.5rem 1rem">{{ $trackedShipment->status_label }}</span>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:2rem;margin-bottom:2rem;background:var(--gray-50);border-radius:12px;padding:1.5rem">
                    <div>
                        <div style="font-size:.85rem;color:var(--gray-500);margin-bottom:.3rem;text-transform:uppercase;font-weight:700">Pengirim</div>
                        <div style="font-weight:600;font-size:1.1rem">{{ $trackedShipment->sender?->name ?? 'Anonim' }}</div>
                        <div style="color:var(--gray-600);font-size:.9rem">{{ $trackedShipment->origin_city }}</div>
                    </div>
                    <div>
                        <div style="font-size:.85rem;color:var(--gray-500);margin-bottom:.3rem;text-transform:uppercase;font-weight:700">Penerima</div>
                        <div style="font-weight:600;font-size:1.1rem">{{ $trackedShipment->receiver?->name ?? '-' }}</div>
                        <div style="color:var(--gray-600);font-size:.9rem">{{ $trackedShipment->destination_city }}</div>
                    </div>
                </div>

                <h3 style="font-size:1.2rem;font-weight:800;margin-bottom:1.5rem">Riwayat Perjalanan</h3>
                <div class="timeline">
                    @forelse($trackedShipment->trackings as $trk)
                    <div class="timeline-item">
                        <div class="timeline-dot {{ $loop->first ? 'current' : 'active' }}"></div>
                        <div class="timeline-content" style="background:#fff;border:1px solid var(--gray-200);box-shadow:var(--shadow-sm)">
                            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:.3rem">
                                <strong style="color:var(--gray-900);font-size:1.05rem">{{ \App\Models\Shipment::statusLabels()[$trk->status] ?? $trk->status }}</strong>
                                <span style="font-size:.85rem;color:var(--gray-500);font-weight:600">{{ $trk->checked_at->format('d M Y, H:i') }}</span>
                            </div>
                            @if($trk->location) <div style="color:var(--primary);font-size:.9rem;font-weight:600;margin-bottom:.3rem"><i class="fa fa-location-dot"></i> {{ $trk->location }}</div> @endif
                            <div style="color:var(--gray-600);font-size:.95rem">{{ $trk->description }}</div>
                        </div>
                    </div>
                    @empty
                    <p style="color:var(--gray-400)">Belum ada riwayat pelacakan.</p>
                    @endforelse
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
