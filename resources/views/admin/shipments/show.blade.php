@extends('layouts.app')
@section('title','Detail Pengiriman')
@section('page-title','Detail Pengiriman')
@section('breadcrumb','<a href="'.route('admin.shipments.index').'">Pengiriman</a> / Detail')

@section('content')
<div style="display:grid;grid-template-columns:2fr 1fr;gap:1.5rem;align-items:start">

    <!-- LEFT -->
    <div style="display:flex;flex-direction:column;gap:1.5rem">
        <!-- Header Card -->
        <div class="table-card" style="padding:1.5rem">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:1rem;margin-bottom:1.5rem;padding-bottom:1.5rem;border-bottom:1px solid var(--gray-100)">
                <div>
                    <div style="font-size:.8rem;color:var(--gray-400);margin-bottom:.3rem">No. Resi</div>
                    <div style="font-size:1.4rem;font-weight:800;color:var(--gray-900);font-family:monospace">{{ $shipment->tracking_number }}</div>
                    <div style="margin-top:.4rem;display:flex;gap:.5rem;flex-wrap:wrap">
                        <span class="badge badge-{{ $shipment->status }}">{{ $shipment->status_label }}</span>
                        <span class="badge badge-{{ $shipment->payment_status }}">{{ ucfirst($shipment->payment_status) }}</span>
                    </div>
                </div>
                <div style="display:flex;gap:.5rem;flex-wrap:wrap">
                    @if(in_array(auth()->guard('web')->user()->role,['admin','branch_admin']))
                    <button onclick="document.getElementById('modal-status').showModal()" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Update Status</button>
                    @endif
                    @if(auth()->guard('web')->user()->role === 'admin' && in_array($shipment->status,['pending','picked_up']))
                    <a href="{{ route('admin.shipments.edit',$shipment) }}" class="btn btn-secondary btn-sm"><i class="fa fa-pen"></i> Edit</a>
                    @endif
                    <a href="{{ route('admin.shipments.index') }}" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i> Kembali</a>
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                @foreach([
                    ['Pengirim', ($shipment->sender_name ?? ($shipment->sender?->name ?? '-')) . "\n" . ($shipment->sender_phone ?? '') . "\n" . $shipment->sender_address],
                    ['Penerima', ($shipment->receiver_name ?? ($shipment->receiver?->name ?? '-')) . "\n" . ($shipment->receiver_phone ?? '') . "\n" . $shipment->receiver_address],
                    ['Cabang Asal',$shipment->originBranch?->name ?? $shipment->origin_city],
                    ['Cabang Tujuan',$shipment->destinationBranch?->name ?? $shipment->destination_city],
                    ['Layanan',$shipment->service?->name ?? '-'],
                    ['Kurir',$shipment->courier?->name ?? '-'],
                    ['Kendaraan',$shipment->vehicle?->plate_number ?? '-'],
                    ['Tgl. Pengiriman',optional($shipment->shipment_date)->format('d M Y')],
                    ['Est. Tiba',optional($shipment->estimated_delivery_date)->format('d M Y') ?? '-'],
                    ['Berat Total',number_format($shipment->total_weight,2).' kg'],
                ] as [$label,$val])
                <div style="background:var(--gray-50);border-radius:8px;padding:.9rem">
                    <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:var(--gray-400);margin-bottom:.25rem">{{ $label }}</div>
                    <div style="font-weight:600;font-size:.875rem;white-space:pre-line">{{ $val }}</div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Items -->
        @if($shipment->items->isNotEmpty())
        <div class="table-card">
            <div class="table-card-header"><h3><i class="fa fa-list"></i> Item Paket</h3></div>
            <table>
                <thead><tr><th>Nama Item</th><th>Deskripsi</th><th>Qty</th><th>Berat</th></tr></thead>
                <tbody>
                @foreach($shipment->items as $item)
                <tr>
                    <td>{{ $item->item_name }}</td>
                    <td style="color:var(--gray-600);font-size:.85rem">{{ $item->description ?? '-' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->weight,2) }} kg</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <!-- Tracking -->
        <div class="table-card" style="padding:1.5rem">
            <h3 style="margin-bottom:1.2rem;font-size:1rem"><i class="fa fa-timeline" style="color:var(--primary)"></i> Riwayat Pelacakan</h3>
            <div class="timeline">
                @forelse($shipment->trackings as $trk)
                <div class="timeline-item">
                    <div class="timeline-dot {{ $loop->first?'current':'active' }}"></div>
                    <div class="timeline-content">
                        <strong>{{ \App\Models\Shipment::statusLabels()[$trk->status] ?? $trk->status }}</strong>
                        @if($trk->location) <span style="color:var(--gray-400);font-size:.8rem"> — {{ $trk->location }}</span> @endif
                        @if($trk->description)<small>{{ $trk->description }}</small>@endif
                        <small style="color:var(--gray-400)">{{ $trk->checked_at->format('d M Y, H:i') }}
                            @if($trk->recorder) · oleh {{ $trk->recorder->name }} @endif
                        </small>
                    </div>
                </div>
                @empty<p style="color:var(--gray-400)">Belum ada riwayat.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- RIGHT: Summary -->
    <div style="display:flex;flex-direction:column;gap:1.5rem">
        <div class="table-card" style="padding:1.5rem">
            <h3 style="margin-bottom:1.2rem;font-size:1rem"><i class="fa fa-receipt" style="color:var(--primary)"></i> Ringkasan Biaya</h3>
            <div style="border-top:2px solid var(--primary);padding-top:1rem;margin-top:1rem">
                <div style="display:flex;justify-content:space-between;margin-bottom:.5rem">
                    <span style="font-size:.875rem;color:var(--gray-600)">Total Harga</span>
                    <span style="font-weight:800;font-size:1.1rem">Rp {{ number_format($shipment->total_price,0,',','.') }}</span>
                </div>
                <div style="display:flex;justify-content:space-between">
                    <span style="font-size:.875rem;color:var(--gray-600)">Status Bayar</span>
                    <span class="badge badge-{{ $shipment->payment_status }}">{{ ucfirst($shipment->payment_status) }}</span>
                </div>
            </div>
            @if(auth()->guard('web')->user()->role === 'admin')
            <a href="{{ route('admin.payments.create',['shipment_id'=>$shipment->id]) }}" class="btn btn-success" style="width:100%;justify-content:center;margin-top:1rem">
                <i class="fa fa-credit-card"></i> Tambah Pembayaran
            </a>
            @endif
        </div>

        @if($shipment->payments->isNotEmpty())
        <div class="table-card" style="padding:1.5rem">
            <h3 style="margin-bottom:1rem;font-size:1rem"><i class="fa fa-credit-card"></i> Pembayaran</h3>
            @foreach($shipment->payments as $p)
            <div style="background:var(--gray-50);border-radius:8px;padding:.8rem;margin-bottom:.5rem">
                <div style="font-size:.75rem;font-family:monospace;color:var(--gray-600);margin-bottom:.25rem">{{ $p->payment_number }}</div>
                <div style="display:flex;justify-content:space-between">
                    <span style="font-size:.8rem">{{ ucfirst(str_replace('_',' ',$p->payment_method)) }}</span>
                    <strong style="color:var(--success)">Rp {{ number_format($p->amount,0,',','.') }}</strong>
                </div>
                <div style="font-size:.75rem;color:var(--gray-400);margin-top:.2rem">{{ optional($p->payment_date)->format('d M Y') }}</div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

<!-- Status Modal -->
@if(in_array(auth()->guard('web')->user()->role,['admin','branch_admin']))
<dialog id="modal-status" style="border:none;border-radius:16px;padding:0;max-width:400px;width:95%;box-shadow:0 20px 60px rgba(0,0,0,.25)">
    <div style="padding:1.5rem">
        <h3 style="margin-bottom:1rem;font-size:1rem">Update Status Pengiriman</h3>
        @php $routeUpdate = auth()->guard('web')->user()->role === 'admin' ? route('admin.shipments.updateStatus',$shipment) : route('branch.shipments.updateStatus',$shipment) @endphp
        <form action="{{ $routeUpdate }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Status Baru</label>
                <select name="status" class="form-control" required>
                    @foreach(\App\Models\Shipment::statusLabels() as $val=>$label)
                    @if($val !== 'pending')
                    <option value="{{ $val }}" {{ $shipment->status===$val?'selected':'' }}>{{ $label }}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Lokasi</label>
                <input type="text" name="location" class="form-control" placeholder="cth. Bandung Hub">
            </div>
            <div class="form-group">
                <label class="form-label">Keterangan</label>
                <textarea name="description" class="form-control" rows="2" placeholder="Keterangan tambahan..."></textarea>
            </div>
            <div style="display:flex;gap:.5rem">
                <button type="submit" class="btn btn-primary" style="flex:1;justify-content:center">Simpan</button>
                <button type="button" onclick="document.getElementById('modal-status').close()" class="btn btn-secondary">Batal</button>
            </div>
        </form>
    </div>
</dialog>
@endif
@endsection
