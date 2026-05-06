@extends('layouts.app')
@section('title','Tambah Pembayaran')
@section('page-title','Tambah Pembayaran')
@section('content')
<div class="form-card" style="max-width:580px">
    <div class="form-card-header"><h3><i class="fa fa-credit-card" style="color:var(--primary)"></i> Form Pembayaran</h3></div>
    <form action="{{ route('admin.payments.store') }}" method="POST">
        @csrf
        <div class="form-card-body">
            <div class="form-group"><label class="form-label">Pengiriman *</label>
                <select name="shipment_id" class="form-control {{ $errors->has('shipment_id')?'is-invalid':'' }}" required>
                    <option value="">-- Pilih Pengiriman --</option>
                    @foreach($shipments as $s)
                    <option value="{{ $s->id }}" {{ (old('shipment_id',$selectedShipment?->id)==$s->id)?'selected':'' }}>
                        {{ $s->tracking_number }} — {{ $s->sender?->name }} — Rp {{ number_format($s->total_price,0,',','.') }}
                    </option>
                    @endforeach
                </select>
                @error('shipment_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>

            @if($selectedShipment)
            <div style="background:var(--orange-bg);border:1px solid rgba(238,77,45,.2);border-radius:8px;padding:1rem;margin-bottom:1rem;font-size:.875rem">
                <div style="display:flex;justify-content:space-between;margin-bottom:.4rem">
                    <span style="color:var(--gray-600)">Total Harga</span>
                    <strong>Rp {{ number_format($selectedShipment->total_price,0,',','.') }}</strong>
                </div>
                <div style="display:flex;justify-content:space-between">
                    <span style="color:var(--gray-600)">Status Bayar</span>
                    <span class="badge badge-{{ $selectedShipment->payment_status }}">{{ ucfirst($selectedShipment->payment_status) }}</span>
                </div>
            </div>
            @endif

            <div class="form-row">
                <div class="form-group"><label class="form-label">Jumlah Bayar (Rp) *</label>
                    <input type="number" name="amount" class="form-control {{ $errors->has('amount')?'is-invalid':'' }}" min="1" value="{{ old('amount', $selectedShipment?->total_price) }}" required>
                    @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="form-group"><label class="form-label">Metode Bayar *</label>
                    <select name="payment_method" class="form-control" required>
                        @foreach(['cash'=>'Tunai','bank_transfer'=>'Transfer Bank','e_wallet'=>'E-Wallet'] as $v=>$l)
                        <option value="{{ $v }}" {{ old('payment_method')===$v?'selected':'' }}>{{ $l }}</option>
                        @endforeach
                    </select></div>
            </div>
            <div class="form-group"><label class="form-label">Tanggal Bayar *</label>
                <input type="date" name="payment_date" class="form-control" value="{{ old('payment_date', date('Y-m-d')) }}" required></div>
            <div class="form-group"><label class="form-label">Catatan</label>
                <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea></div>
        </div>
        <div class="form-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
            <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
