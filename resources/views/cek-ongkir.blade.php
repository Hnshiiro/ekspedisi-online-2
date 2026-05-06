@extends('layouts.landing')
@section('title','Cek Ongkir')
@section('content')
<div style="background:linear-gradient(135deg,#1a1a2e,#16213e);padding:3rem 1.5rem;text-align:center;color:#fff">
    <h1 style="font-size:2rem;font-weight:800;margin-bottom:.5rem">💰 Cek Ongkos Kirim</h1>
    <p style="color:rgba(255,255,255,.65)">Estimasi biaya pengiriman ke seluruh Indonesia</p>
</div>

<div style="max-width:700px;margin:2.5rem auto;padding:0 1.5rem">
    <div style="background:#fff;border-radius:16px;padding:2rem;box-shadow:0 4px 24px rgba(0,0,0,.08);border:1px solid var(--gray-200)">
        <form action="{{ route('cek-ongkir') }}" method="POST">
            @csrf
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem">
                <div class="form-group">
                    <label class="form-label">Kota Asal</label>
                    <input type="text" name="origin" list="origin-list" class="form-control {{ $errors->has('origin') ? 'is-invalid' : '' }}"
                        placeholder="cth. Jakarta" value="{{ old('origin') }}" required>
                    <datalist id="origin-list">
                        @foreach($routes as $r)<option value="{{ $r }}">@endforeach
                    </datalist>
                    @error('origin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Kota Tujuan</label>
                    <input type="text" name="destination" class="form-control {{ $errors->has('destination') ? 'is-invalid' : '' }}"
                        placeholder="cth. Surabaya" value="{{ old('destination') }}" required>
                    @error('destination')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem">
                <div class="form-group">
                    <label class="form-label">Berat (kg)</label>
                    <input type="number" name="weight" step="0.1" min="0.1" class="form-control {{ $errors->has('weight') ? 'is-invalid' : '' }}"
                        placeholder="cth. 2.5" value="{{ old('weight') }}" required>
                    @error('weight')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Layanan</label>
                    <select name="service_id" class="form-control {{ $errors->has('service_id') ? 'is-invalid' : '' }}" required>
                        <option value="">-- Pilih Layanan --</option>
                        @foreach($services as $svc)
                        <option value="{{ $svc->id }}" {{ old('service_id') == $svc->id ? 'selected' : '' }}>
                            {{ $svc->name }} ({{ $svc->price_multiplier }}x)
                        </option>
                        @endforeach
                    </select>
                    @error('service_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;padding:.8rem;font-size:1rem;justify-content:center">
                <i class="fa fa-calculator"></i> Hitung Ongkir
            </button>
        </form>

        @if(isset($result))
        <div style="margin-top:1.5rem;background:linear-gradient(135deg,var(--orange-bg),#fff);border:2px solid var(--primary);border-radius:12px;padding:1.5rem">
            <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem">
                <div>
                    <div style="font-size:.8rem;color:var(--gray-600);margin-bottom:.3rem">Rute</div>
                    <div style="font-weight:700;font-size:1rem">{{ $result['route']->origin_city }} → {{ $result['route']->destination_city }}</div>
                </div>
                <div style="text-align:right">
                    <div style="font-size:.8rem;color:var(--gray-600);margin-bottom:.3rem">Estimasi Ongkir</div>
                    <div style="font-size:1.6rem;font-weight:800;color:var(--primary)">Rp {{ number_format($result['final_price'],0,',','.') }}</div>
                </div>
            </div>
            <div style="border-top:1px solid rgba(238,77,45,.2);margin-top:1rem;padding-top:1rem;display:grid;grid-template-columns:repeat(3,1fr);gap:.75rem;text-align:center;font-size:.85rem">
                <div><div style="color:var(--gray-500)">Berat</div><strong>{{ $result['weight'] }} kg</strong></div>
                <div><div style="color:var(--gray-500)">Layanan</div><strong>{{ $result['service']->name }}</strong></div>
                <div><div style="color:var(--gray-500)">Estimasi Tiba</div><strong>{{ $result['estimated_days'] }} hari</strong></div>
            </div>
        </div>
        @elseif(request()->isMethod('post'))
        <div style="margin-top:1.5rem;background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:1.2rem;text-align:center;color:#991b1b">
            <i class="fa fa-exclamation-triangle"></i> Rute tidak tersedia untuk kota yang dipilih.
        </div>
        @endif
    </div>
</div>
@endsection
