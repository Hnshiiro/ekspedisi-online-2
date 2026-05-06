@extends('layouts.app')
@section('title','Tambah Pengiriman')
@section('page-title','Tambah Pengiriman')
@section('breadcrumb','<a href="'.route('admin.shipments.index').'">Pengiriman</a> / Tambah')

@section('content')
<form action="{{ route('admin.shipments.store') }}" method="POST" id="shipment-form">
@csrf
<div style="display:grid;grid-template-columns:2fr 1fr;gap:1.5rem;align-items:start">
<div style="display:flex;flex-direction:column;gap:1.5rem">

<!-- Pengirim & Penerima -->
<div class="form-card">
    <div class="form-card-header"><h3><i class="fa fa-users" style="color:var(--primary)"></i> Data Pengirim & Penerima</h3></div>
    <div class="form-card-body">
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Pengirim *</label>
                <select name="sender_id" class="form-control {{ $errors->has('sender_id')?'is-invalid':'' }}" required>
                    <option value="">-- Pilih Pengirim --</option>
                    @foreach($customers as $c)<option value="{{ $c->id }}" {{ old('sender_id')==$c->id?'selected':'' }}>{{ $c->name }} ({{ $c->city }})</option>@endforeach
                </select>
                @error('sender_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Penerima *</label>
                <select name="receiver_id" class="form-control {{ $errors->has('receiver_id')?'is-invalid':'' }}" required>
                    <option value="">-- Pilih Penerima --</option>
                    @foreach($customers as $c)<option value="{{ $c->id }}" {{ old('receiver_id')==$c->id?'selected':'' }}>{{ $c->name }} ({{ $c->city }})</option>@endforeach
                </select>
                @error('receiver_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Alamat Pengirim *</label>
                <textarea name="sender_address" class="form-control {{ $errors->has('sender_address')?'is-invalid':'' }}" rows="2" required>{{ old('sender_address') }}</textarea>
                @error('sender_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Alamat Penerima *</label>
                <textarea name="receiver_address" class="form-control {{ $errors->has('receiver_address')?'is-invalid':'' }}" rows="2" required>{{ old('receiver_address') }}</textarea>
                @error('receiver_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>
</div>

<!-- Rute -->
<div class="form-card">
    <div class="form-card-header"><h3><i class="fa fa-route" style="color:var(--primary)"></i> Rute & Cabang</h3></div>
    <div class="form-card-body">
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Cabang Asal *</label>
                <select name="origin_branch_id" class="form-control" required>
                    <option value="">-- Pilih Cabang --</option>
                    @foreach($branches as $b)<option value="{{ $b->id }}" {{ old('origin_branch_id')==$b->id?'selected':'' }}>{{ $b->name }}</option>@endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Cabang Tujuan *</label>
                <select name="destination_branch_id" class="form-control" required>
                    <option value="">-- Pilih Cabang --</option>
                    @foreach($branches as $b)<option value="{{ $b->id }}" {{ old('destination_branch_id')==$b->id?'selected':'' }}>{{ $b->name }}</option>@endforeach
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Kota Asal *</label>
                <input type="text" name="origin_city" class="form-control" value="{{ old('origin_city') }}" required placeholder="cth. Jakarta">
            </div>
            <div class="form-group">
                <label class="form-label">Kota Tujuan *</label>
                <input type="text" name="destination_city" class="form-control" value="{{ old('destination_city') }}" required placeholder="cth. Surabaya">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Rute (Opsional)</label>
            <select name="route_id" class="form-control">
                <option value="">-- Pilih Rute --</option>
                @foreach($routes as $r)<option value="{{ $r->id }}" {{ old('route_id')==$r->id?'selected':'' }}>{{ $r->origin_city }} → {{ $r->destination_city }} (Rp {{ number_format($r->price_per_kg,0,',','.') }}/kg, {{ $r->estimated_days }} hari)</option>@endforeach
            </select>
        </div>
    </div>
</div>

<!-- Items -->
<div class="form-card">
    <div class="form-card-header"><h3><i class="fa fa-boxes-stacked" style="color:var(--primary)"></i> Item Paket</h3></div>
    <div class="form-card-body">
        <div id="items-container">
            <div class="item-row" style="display:grid;grid-template-columns:2fr 1fr 1fr auto;gap:.75rem;align-items:start;margin-bottom:.75rem">
                <div><label class="form-label">Nama Item *</label><input type="text" name="items[0][item_name]" class="form-control" placeholder="Nama barang" required></div>
                <div><label class="form-label">Qty</label><input type="number" name="items[0][quantity]" class="form-control" value="1" min="1"></div>
                <div><label class="form-label">Berat (kg)</label><input type="number" name="items[0][weight]" class="form-control" step="0.1" min="0" value="0"></div>
                <div style="padding-top:1.6rem"><button type="button" onclick="this.closest('.item-row').remove()" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></div>
            </div>
        </div>
        <button type="button" onclick="addItem()" class="btn btn-secondary btn-sm"><i class="fa fa-plus"></i> Tambah Item</button>
    </div>
</div>

</div>

<!-- RIGHT SIDEBAR -->
<div style="display:flex;flex-direction:column;gap:1.5rem">
<div class="form-card">
    <div class="form-card-header"><h3><i class="fa fa-settings" style="color:var(--primary)"></i> Info Pengiriman</h3></div>
    <div class="form-card-body">
        <div class="form-group">
            <label class="form-label">Layanan *</label>
            <select name="service_id" class="form-control" required>
                <option value="">-- Pilih Layanan --</option>
                @foreach($services as $s)<option value="{{ $s->id }}" {{ old('service_id')==$s->id?'selected':'' }}>{{ $s->name }} ({{ $s->price_multiplier }}x)</option>@endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Kurir</label>
            <select name="courier_id" class="form-control">
                <option value="">-- Pilih Kurir --</option>
                @foreach($couriers as $c)<option value="{{ $c->id }}" {{ old('courier_id')==$c->id?'selected':'' }}>{{ $c->name }}</option>@endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Kendaraan</label>
            <select name="vehicle_id" class="form-control">
                <option value="">-- Pilih Kendaraan --</option>
                @foreach($vehicles as $v)<option value="{{ $v->id }}" {{ old('vehicle_id')==$v->id?'selected':'' }}>{{ $v->plate_number }} - {{ $v->brand }}</option>@endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Total Berat (kg) *</label>
            <input type="number" name="total_weight" class="form-control" step="0.1" min="0.1" value="{{ old('total_weight') }}" required>
        </div>
        <div class="form-group">
            <label class="form-label">Total Harga (Rp) *</label>
            <input type="number" name="total_price" class="form-control" min="0" value="{{ old('total_price') }}" required>
        </div>
        <div class="form-group">
            <label class="form-label">Tanggal Kirim *</label>
            <input type="date" name="shipment_date" class="form-control" value="{{ old('shipment_date', date('Y-m-d')) }}" required>
        </div>
        <div class="form-group">
            <label class="form-label">Est. Tiba</label>
            <input type="date" name="estimated_delivery_date" class="form-control" value="{{ old('estimated_delivery_date') }}">
        </div>
        <div class="form-group">
            <label class="form-label">Deskripsi / Catatan</label>
            <textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea>
        </div>
    </div>
</div>
<div class="form-card">
    <div class="form-card-body">
        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center"><i class="fa fa-save"></i> Buat Pengiriman</button>
        <a href="{{ route('admin.shipments.index') }}" class="btn btn-secondary" style="width:100%;justify-content:center;margin-top:.5rem"><i class="fa fa-times"></i> Batal</a>
    </div>
</div>
</div>

</div>
</form>
@push('scripts')
<script>
let itemCount = 1;
function addItem(){
    itemCount++;
    document.getElementById('items-container').insertAdjacentHTML('beforeend',`
        <div class="item-row" style="display:grid;grid-template-columns:2fr 1fr 1fr auto;gap:.75rem;align-items:start;margin-bottom:.75rem">
            <div><label class="form-label">Nama Item</label><input type="text" name="items[${itemCount}][item_name]" class="form-control" placeholder="Nama barang"></div>
            <div><label class="form-label">Qty</label><input type="number" name="items[${itemCount}][quantity]" class="form-control" value="1" min="1"></div>
            <div><label class="form-label">Berat (kg)</label><input type="number" name="items[${itemCount}][weight]" class="form-control" step="0.1" min="0" value="0"></div>
            <div style="padding-top:1.6rem"><button type="button" onclick="this.closest('.item-row').remove()" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></div>
        </div>
    `);
}
</script>
@endpush
@endsection
