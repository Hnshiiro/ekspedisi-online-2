@extends('layouts.landing')

@section('title', 'Beranda')

@section('content')

<!-- HERO -->
<section class="hero">
    <div class="hero-content">
        <div>
            <div class="hero-badge"><i class="fa fa-bolt"></i> #1 Ekspedisi Terpercaya Indonesia</div>
            <h1>Kirim Paket Lebih <span>Cepat</span> &amp; Lebih <span>Hemat</span></h1>
            <p>Lebih dari 500 kota tujuan di seluruh Indonesia. Lacak paket secara real-time dan dapatkan estimasi biaya pengiriman secara instan.</p>
            <div class="hero-actions">
                <a href="{{ route('customer.shipments.create') }}" class="btn btn-primary" style="padding:.75rem 1.5rem;font-size:1rem">
                    <i class="fa fa-box"></i> Mulai Kirim
                </a>
                <a href="{{ route('tracking') }}" class="btn" style="background:rgba(255,255,255,.12);color:#fff;padding:.75rem 1.5rem;font-size:1rem;border:1px solid rgba(255,255,255,.25)">
                    <i class="fa fa-magnifying-glass"></i> Lacak Paket
                </a>
            </div>
            <!-- Quick Track Box -->
            <div class="hero-track-box" style="margin-top:2rem">
                <h3><i class="fa fa-location-dot" style="color:var(--primary)"></i> Lacak Paket Anda</h3>
                <form action="{{ route('home') }}" method="GET">
                    <div class="track-input-row">
                        <input type="text" name="tracking_number" class="track-input"
                            placeholder="Masukkan No. Resi (contoh: EKS-XXXXXXXXXX)"
                            value="{{ $trackingNumber ?? '' }}">
                        <button type="submit" class="btn btn-primary" style="white-space:nowrap;padding:.75rem 1.2rem">
                            <i class="fa fa-search"></i> Lacak
                        </button>
                    </div>
                </form>

                @if($trackingNumber && !$trackedShipment)
                    <div style="background:rgba(220,38,38,.15);border-radius:8px;padding:.75rem;margin-top:1rem;color:#ff8066;font-size:.875rem">
                        <i class="fa fa-exclamation-circle"></i> Nomor resi "<strong>{{ $trackingNumber }}</strong>" tidak ditemukan.
                    </div>
                @endif

                @if($trackedShipment)
                <div style="background:rgba(255,255,255,.08);border-radius:10px;padding:1.2rem;margin-top:1rem;border:1px solid rgba(255,255,255,.15)">
                    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:.5rem;margin-bottom:1rem">
                        <div>
                            <div style="font-size:.8rem;color:rgba(255,255,255,.5);margin-bottom:.2rem">No. Resi</div>
                            <div style="font-weight:700;color:#fff;font-size:.95rem">{{ $trackedShipment->tracking_number }}</div>
                        </div>
                        <span class="status-badge status-{{ $trackedShipment->status }}" style="font-size:.75rem">
                            {{ $trackedShipment->status_label }}
                        </span>
                    </div>
                    <div style="font-size:.8rem;color:rgba(255,255,255,.6)">
                        <i class="fa fa-location-arrow"></i>
                        {{ $trackedShipment->origin_city }} → {{ $trackedShipment->destination_city }}
                        &nbsp;|&nbsp; {{ $trackedShipment->service?->name ?? 'Reguler' }}
                    </div>
                    <a href="{{ route('tracking') }}?no={{ $trackedShipment->tracking_number }}" style="display:inline-block;margin-top:.75rem;font-size:.8rem;color:var(--primary-light);font-weight:600">
                        Lihat Detail Pelacakan →
                    </a>
                </div>
                @endif
            </div>
        </div>
        <div class="hero-right" style="display:flex;justify-content:center;align-items:center">
            <div style="background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);border-radius:20px;padding:2.5rem;text-align:center;backdrop-filter:blur(12px)">
                <div style="font-size:5rem;margin-bottom:1rem">📦</div>
                <div style="font-size:1.2rem;font-weight:700;color:#fff;margin-bottom:.4rem">Pengiriman Terjamin</div>
                <div style="font-size:.875rem;color:rgba(255,255,255,.55)">Asuransi pengiriman tersedia</div>
                <div style="margin-top:1.5rem;display:grid;grid-template-columns:1fr 1fr;gap:1rem;text-align:center">
                    <div style="background:rgba(238,77,45,.15);border-radius:10px;padding:.9rem;border:1px solid rgba(238,77,45,.2)">
                        <div style="font-size:1.6rem;font-weight:800;color:var(--primary)">{{ number_format($totalShipments) }}</div>
                        <div style="font-size:.75rem;color:rgba(255,255,255,.5);margin-top:.2rem">Total Kiriman</div>
                    </div>
                    <div style="background:rgba(38,115,221,.15);border-radius:10px;padding:.9rem;border:1px solid rgba(38,115,221,.2)">
                        <div style="font-size:1.6rem;font-weight:800;color:#60a5fa">{{ number_format($deliveredShipments) }}</div>
                        <div style="font-size:.75rem;color:rgba(255,255,255,.5);margin-top:.2rem">Terkirim</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- STATS RIBBON -->
<div class="stats-ribbon">
    <div class="stats-ribbon-inner">
        <div class="stat-item">
            <strong>{{ number_format($totalShipments) }}+</strong>
            <span>Total Pengiriman</span>
        </div>
        <div class="stat-item">
            <strong>{{ number_format($activeBranches) }}</strong>
            <span>Cabang Aktif</span>
        </div>
        <div class="stat-item">
            <strong>{{ number_format($deliveredShipments) }}+</strong>
            <span>Terkirim Sukses</span>
        </div>
        <div class="stat-item">
            <strong>{{ number_format($totalCustomers) }}+</strong>
            <span>Pelanggan</span>
        </div>
    </div>
</div>

<!-- SERVICES SECTION -->
<section class="section">
    <div class="section-inner">
        <div class="section-title">
            <div class="eyebrow">Layanan Kami</div>
            <h2>Pilih Layanan Sesuai Kebutuhan</h2>
            <p>Tersedia berbagai pilihan layanan pengiriman untuk memenuhi kebutuhan Anda</p>
        </div>
        <div class="service-cards">
            @foreach($services as $svc)
            <div class="service-card">
                <div class="badge-multiplier">{{ $svc->price_multiplier }}x</div>
                <div style="font-size:2rem;margin-bottom:.5rem">
                    {{ ['Reguler'=>'📦','Express'=>'⚡','Same Day'=>'🚀','Kargo'=>'🚛','COD'=>'💵'][$svc->name] ?? '📫' }}
                </div>
                <div style="font-weight:700;font-size:1rem;margin-bottom:.4rem">{{ $svc->name }}</div>
                <div style="font-size:.85rem;color:var(--gray-600)">{{ $svc->description }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- FEATURES SECTION -->
<section class="section section-alt">
    <div class="section-inner">
        <div class="section-title">
            <div class="eyebrow">Keunggulan Kami</div>
            <h2>Mengapa Pilih EkspedisiKu?</h2>
            <p>Kami hadir untuk memberikan pengalaman pengiriman terbaik bagi Anda</p>
        </div>
        <div class="cards-grid">
            <div class="card">
                <div class="card-icon orange"><i class="fa fa-network-wired"></i></div>
                <h3>Jaringan Nasional</h3>
                <p>Pengiriman ke lebih dari 500 kota dan kabupaten di seluruh Indonesia.</p>
            </div>
            <div class="card">
                <div class="card-icon blue"><i class="fa fa-bolt"></i></div>
                <h3>Pengiriman Cepat</h3>
                <p>Layanan Same Day, Express, dan Reguler untuk setiap kebutuhan Anda.</p>
            </div>
            <div class="card">
                <div class="card-icon green"><i class="fa fa-location-dot"></i></div>
                <h3>Tracking Real-time</h3>
                <p>Pantau status pengiriman paket Anda secara langsung kapan saja.</p>
            </div>
            <div class="card">
                <div class="card-icon purple"><i class="fa fa-shield-halved"></i></div>
                <h3>Terjamin Aman</h3>
                <p>Sistem keamanan paket berlapis dan asuransi pengiriman tersedia.</p>
            </div>
        </div>
    </div>
</section>

<!-- QUICK ACTIONS -->
<section class="section">
    <div class="section-inner">
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:1.5rem">
            <a href="{{ route('tracking') }}" style="background:linear-gradient(135deg,#EE4D2D,#ff6b4a);border-radius:var(--radius);padding:2rem;color:#fff;display:flex;align-items:center;gap:1.2rem;transition:transform .2s;text-decoration:none" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="font-size:2.5rem">🔍</div>
                <div>
                    <div style="font-size:1.1rem;font-weight:800;margin-bottom:.25rem">Lacak Paket</div>
                    <div style="font-size:.85rem;opacity:.85">Cek status pengiriman Anda</div>
                </div>
            </a>
            <a href="{{ route('cek-ongkir') }}" style="background:linear-gradient(135deg,#2673DD,#1a5bbf);border-radius:var(--radius);padding:2rem;color:#fff;display:flex;align-items:center;gap:1.2rem;transition:transform .2s;text-decoration:none" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="font-size:2.5rem">💰</div>
                <div>
                    <div style="font-size:1.1rem;font-weight:800;margin-bottom:.25rem">Cek Ongkir</div>
                    <div style="font-size:.85rem;opacity:.85">Estimasi biaya pengiriman</div>
                </div>
            </a>
            <a href="{{ route('customer.register') }}" style="background:linear-gradient(135deg,#16a34a,#15803d);border-radius:var(--radius);padding:2rem;color:#fff;display:flex;align-items:center;gap:1.2rem;transition:transform .2s;text-decoration:none" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="font-size:2.5rem">👤</div>
                <div>
                    <div style="font-size:1.1rem;font-weight:800;margin-bottom:.25rem">Daftar Sekarang</div>
                    <div style="font-size:.85rem;opacity:.85">Buat akun pelanggan gratis</div>
                </div>
            </a>
        </div>
    </div>
</section>

@endsection
