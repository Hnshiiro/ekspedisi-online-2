@extends('customer.dashboard')
@section('customer-content')
<div style="background:#fff;border-radius:16px;border:1px solid var(--gray-200);box-shadow:var(--shadow);overflow:hidden">
    <div style="padding:1.5rem;border-bottom:1px solid var(--gray-100);display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem">
        <h2 style="font-size:1.2rem;font-weight:800"><i class="fa fa-box" style="color:var(--primary)"></i> Riwayat Kiriman Saya</h2>
        <div style="display:flex;gap:.5rem;align-items:center">
            <a href="{{ route('customer.shipments.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Kirim Paket</a>
            <form action="">
                <select name="status" onchange="this.form.submit()" class="form-control" style="width:auto;padding:.4rem .8rem;font-size:.85rem">
                    <option value="">Semua Status</option>
                    @foreach($statuses as $st)<option value="{{ $st }}" {{ request('status')==$st?'selected':'' }}>{{ \App\Models\Shipment::statusLabels()[$st] }}</option>@endforeach
                </select>
            </form>
        </div>
    </div>
    <div style="padding:1rem">
        @forelse($shipments as $s)
        <div style="border:1px solid var(--gray-200);border-radius:12px;padding:1.2rem;margin-bottom:1rem">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:1rem;margin-bottom:1rem;padding-bottom:1rem;border-bottom:1px dashed var(--gray-200)">
                <div>
                    <div style="font-family:monospace;font-weight:800;font-size:1.1rem;color:var(--primary)">{{ $s->tracking_number }}</div>
                    <div style="font-size:.8rem;color:var(--gray-500);margin-top:.2rem"><i class="fa fa-calendar"></i> {{ $s->created_at->format('d M Y') }}</div>
                </div>
                <span class="status-badge status-{{ $s->status }}">{{ $s->status_label }}</span>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;font-size:.875rem">
                <div>
                    <div style="color:var(--gray-500);font-size:.75rem;margin-bottom:.4rem;text-transform:uppercase;letter-spacing:0.025em">Informasi Pengirim</div>
                    <div style="display:flex;flex-direction:column;gap:.25rem">
                        <strong>{{ $s->sender_name ?? $s->sender?->name ?? '-' }}</strong>
                        <span style="color:var(--gray-600)"><i class="fa fa-phone" style="width:16px"></i> {{ $s->sender_phone ?? $s->sender?->phone ?? '-' }}</span>
                        <span style="color:var(--gray-600)"><i class="fa fa-map-marker-alt" style="width:16px"></i> {{ $s->origin_city }}</span>
                        <span style="color:var(--gray-600)"><i class="fa fa-building" style="width:16px"></i> Cabang: {{ $s->originBranch->name ?? '-' }}</span>
                    </div>
                </div>
                <div>
                    <div style="color:var(--gray-500);font-size:.75rem;margin-bottom:.4rem;text-transform:uppercase;letter-spacing:0.025em">Informasi Penerima</div>
                    <div style="display:flex;flex-direction:column;gap:.25rem">
                        <strong>{{ $s->receiver_name ?? $s->receiver?->name ?? '-' }}</strong>
                        <span style="color:var(--gray-600)"><i class="fa fa-phone" style="width:16px"></i> {{ $s->receiver_phone ?? '-' }}</span>
                        <span style="color:var(--gray-600)"><i class="fa fa-map-marker-alt" style="width:16px"></i> {{ $s->destination_city }}</span>
                    </div>
                </div>
            </div>
            <div style="margin-top:1.5rem;padding-top:1rem;border-top:1px solid var(--gray-100);display:flex;justify-content:space-between;align-items:center">
                <div style="font-size:.8rem;color:var(--gray-500)">
                    <i class="fa fa-truck"></i> Layanan: <strong>{{ $s->service->name ?? '-' }}</strong>
                </div>
                <div style="display:flex;gap:.5rem">
                    @if($s->payment_status === 'unpaid')
                        <button onclick="getNewSnapToken('{{ $s->id }}')" id="pay-btn-{{ $s->id }}" class="btn btn-primary" style="padding:.4rem 1rem;font-size:.85rem"><i class="fa fa-credit-card"></i> Bayar Sekarang</button>
                    @endif
                    <a href="{{ route('customer.track') }}?no={{ $s->tracking_number }}" class="btn btn-outline" style="padding:.4rem 1rem;font-size:.85rem">Lacak Paket</a>
                </div>
            </div>
        </div>
        @empty
        <div style="text-align:center;padding:3rem 1.5rem;color:var(--gray-400)"><i class="fa fa-box-open" style="font-size:3rem;margin-bottom:1rem"></i><p>Tidak ada data kiriman ditemukan.</p></div>
        @endforelse
    </div>
    @if($shipments->hasPages())<div style="padding:1rem 1.5rem;border-top:1px solid var(--gray-100)">{{ $shipments->links() }}</div>@endif
</div>

@push('scripts')
<script src="{{ config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
    function getNewSnapToken(shipmentId) {
        const btn = document.getElementById('pay-btn-' + shipmentId);
        const originalHtml = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';

        fetch(`/pelanggan/pengiriman/${shipmentId}/bayar`)
            .then(response => response.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = originalHtml;
                if (data.snap_token) {
                    payWithSnap(data.snap_token);
                } else {
                    alert('Gagal mendapatkan token pembayaran: ' + (data.error || 'Unknown error'));
                }
            })
            .catch(error => {
                btn.disabled = false;
                btn.innerHTML = originalHtml;
                alert('Terjadi kesalahan jaringan.');
                console.error(error);
            });
    }

    function payWithSnap(snapToken) {
        snap.pay(snapToken, {
            onSuccess: function(result){
                window.location.reload();
            },
            onPending: function(result){
                window.location.reload();
            },
            onError: function(result){
                alert('Pembayaran gagal!');
            },
            onClose: function(){
                // user closed the popup
            }
        });
    }

    @if(session('pay_snap_token'))
        payWithSnap('{{ session('pay_snap_token') }}');
    @endif
</script>
@endpush
@endsection
