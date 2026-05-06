@extends('customer.dashboard')
@section('customer-content')
<div style="background:#fff;border-radius:16px;border:1px solid var(--gray-200);box-shadow:var(--shadow);overflow:hidden;padding:1.5rem">
    <h2 style="font-size:1.2rem;font-weight:800;margin-bottom:1.5rem"><i class="fa fa-paper-plane" style="color:var(--primary)"></i> Buat Permintaan Pengiriman</h2>
    
    <div style="background:#fff8f1;border:1px solid #ffedd5;border-radius:10px;padding:1rem;margin-bottom:1.5rem;font-size:.875rem;color:#c2410c">
        <i class="fa fa-circle-info"></i> Isi form di bawah ini untuk memesan penjemputan paket. Kurir kami akan datang ke alamat Anda <strong>({{ auth()->guard('customer')->user()->address }}, {{ auth()->guard('customer')->user()->city }})</strong> untuk menjemput paket.
    </div>

    <form action="{{ route('customer.shipments.store') }}" method="POST">
        @csrf
        <h3 style="font-size:1rem;font-weight:700;margin-bottom:1rem;color:var(--gray-900)">Data Pengirim & Penerima</h3>
        <div class="form-group" style="margin-bottom:1.2rem">
            <label class="form-label">Cabang Asal (Tempat Penjemputan / Drop-off) *</label>
            <select name="origin_branch_id" class="form-control" required>
                <option value="">-- Pilih Cabang Terdekat --</option>
                @foreach($branches->where('is_active', true) as $b)
                <option value="{{ $b->id }}" {{ old('origin_branch_id')==$b->id?'selected':'' }}>{{ $b->name }} ({{ $b->city }})</option>
                @endforeach
            </select>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.2rem;margin-bottom:1.2rem">
            <div class="form-group">
                <label class="form-label">Nama Pengirim *</label>
                <input type="text" name="sender_name" class="form-control" value="{{ old('sender_name', auth()->guard('customer')->user()->name) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">No. Telepon Pengirim *</label>
                <input type="text" name="sender_phone" class="form-control" value="{{ old('sender_phone', auth()->guard('customer')->user()->phone) }}" required>
            </div>
        </div>

        <h3 style="font-size:1rem;font-weight:700;margin-bottom:1rem;color:var(--gray-900);border-top:1px solid var(--gray-100);padding-top:1rem">Data Penerima</h3>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.2rem;margin-bottom:1.2rem">
            <div class="form-group">
                <label class="form-label">Nama Penerima *</label>
                <input type="text" name="receiver_name" class="form-control" value="{{ old('receiver_name') }}" placeholder="cth. Budi Santoso" required>
            </div>
            <div class="form-group">
                <label class="form-label">No. Telepon Penerima *</label>
                <input type="text" name="receiver_phone" class="form-control" value="{{ old('receiver_phone') }}" placeholder="08xxxxxxxxxx" required>
            </div>
        </div>
        <div class="form-group" style="margin-bottom:1.2rem">
            <label class="form-label">Kota Tujuan *</label>
            <input type="text" name="destination_city" class="form-control" value="{{ old('destination_city') }}" required placeholder="cth. Bandung">
        </div>
        <div class="form-group" style="margin-bottom:2rem">
            <label class="form-label">Alamat Lengkap Penerima *</label>
            <textarea name="receiver_address" rows="3" class="form-control" required placeholder="Jl. Contoh No. 123, RT/RW, Kel/Kec...">{{ old('receiver_address') }}</textarea>
        </div>

        <h3 style="font-size:1rem;font-weight:700;margin-bottom:1rem;color:var(--gray-900)">Detail Paket & Layanan</h3>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.2rem;margin-bottom:1.2rem">
            <div class="form-group">
                <label class="form-label">Nama Barang / Isi Paket *</label>
                <input type="text" name="item_name" class="form-control" value="{{ old('item_name') }}" required placeholder="cth. Pakaian / Dokumen">
            </div>
            <div class="form-group">
                <label class="form-label">Berat Paket (kg) *</label>
                <input type="number" name="weight" step="0.1" min="0.1" class="form-control" value="{{ old('weight', 1.0) }}" required>
            </div>
        </div>
        <div class="form-group" style="margin-bottom:2rem">
            <label class="form-label">Pilih Layanan *</label>
            <select name="service_id" class="form-control" required>
                <option value="">-- Pilih Layanan --</option>
                @foreach($services as $s)
                <option value="{{ $s->id }}" {{ old('service_id')==$s->id?'selected':'' }}>{{ $s->name }} (Tarif Dasar x {{ $s->price_multiplier }})</option>
                @endforeach
            </select>
        </div>

        <h3 style="font-size:1rem;font-weight:700;margin-bottom:1rem;color:var(--gray-900)">Metode Pembayaran</h3>
        <div class="form-group" style="margin-bottom:2rem">
            <label class="form-label">Pilih Metode Pembayaran *</label>
            <select name="payment_method" class="form-control" required>
                <option value="midtrans">Transfer Bank / E-Wallet</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;font-size:1.05rem;padding:.8rem"><i class="fa fa-truck-fast"></i> Proses & Pesan Penjemputan</button>
    </form>
</div>
@endsection
