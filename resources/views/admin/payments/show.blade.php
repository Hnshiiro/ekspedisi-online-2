@extends('layouts.app')
@section('title','Detail Pembayaran')
@section('page-title','Detail Pembayaran')
@section('content')
<div class="table-card" style="max-width:600px;padding:1.5rem">
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:.75rem;margin-bottom:1.5rem;padding-bottom:1.5rem;border-bottom:1px solid var(--gray-100)">
        <div>
            <div style="font-size:.8rem;color:var(--gray-400)">No. Pembayaran</div>
            <div style="font-size:1.2rem;font-weight:800;font-family:monospace">{{ $payment->payment_number }}</div>
        </div>
        <span class="badge badge-{{ $payment->payment_status }}" style="font-size:.85rem;padding:.4rem 1rem">{{ ucfirst($payment->payment_status) }}</span>
    </div>
    @foreach([
        ['Resi Pengiriman', $payment->shipment?->tracking_number??'-'],
        ['Pengirim', $payment->shipment?->sender_name ?? $payment->shipment?->sender?->name ?? '-'],
        ['Penerima', $payment->shipment?->receiver_name ?? $payment->shipment?->receiver?->name ?? '-'],
        ['Jumlah', 'Rp '.number_format($payment->amount,0,',','.')],
        ['Metode', ucwords(str_replace('_',' ',$payment->payment_method))],
        ['Tanggal Bayar', optional($payment->payment_date)->format('d M Y')??'-'],
        ['Diterima Oleh', $payment->receiver?->name??'-'],
        ['Catatan', $payment->notes??'-'],
    ] as [$l,$v])
    <div style="display:flex;justify-content:space-between;padding:.65rem 0;border-bottom:1px solid var(--gray-100);font-size:.875rem">
        <span style="color:var(--gray-500)">{{ $l }}</span><span style="font-weight:600;text-align:right;max-width:280px">{{ $v }}</span>
    </div>
    @endforeach
    <div style="margin-top:1.5rem;display:flex;gap:.5rem;flex-wrap:wrap">
        <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i> Kembali</a>
        @if($payment->payment_status === 'pending')
        <form action="{{ route('admin.payments.markAsPaid', $payment) }}" method="POST" onsubmit="return confirm('Tandai pembayaran ini sebagai SUDAH BAYAR secara manual?')">
            @csrf
            <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-check-circle"></i> Tandai Sudah Bayar</button>
        </form>
        @endif
        @if($payment->shipment)
        <a href="{{ route('admin.shipments.show',$payment->shipment) }}" class="btn btn-info btn-sm"><i class="fa fa-box"></i> Lihat Pengiriman</a>
        @endif
    </div>
</div>
@endsection
