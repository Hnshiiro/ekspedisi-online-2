@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row mb-4 align-items-center">
        <div class="col-md-8">
            <h1 class="h3 mb-0">Dashboard</h1>
            <p class="text-muted">Ringkasan operasional & akses cepat — tampilan terinspirasi SPX.</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <a href="{{ route('shipments.create') }}" class="btn btn-success me-2">+ Buat Pengiriman</a>
            <a href="{{ route('shipments.index') }}" class="btn btn-outline-secondary">Semua Pengiriman</a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <small class="text-muted">Total Pengiriman</small>
                    <div class="h4 fw-bold">{{ $totalShipments ?? 0 }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <small class="text-muted">Dalam Perjalanan</small>
                    <div class="h4 fw-bold text-info">{{ $transitShipments ?? $inTransitShipments ?? 0 }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <small class="text-muted">Terkirim</small>
                    <div class="h4 fw-bold text-success">{{ $deliveredShipments ?? 0 }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <small class="text-muted">Pelanggan</small>
                    <div class="h4 fw-bold">{{ $totalCustomers ?? 0 }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Pengiriman Terbaru</h5>
                        <a href="{{ route('shipments.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>No Resi</th>
                                    <th>Pelanggan</th>
                                    <th>Rute</th>
                                    <th>Status</th>
                                    <th>Pembayaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentShipments as $shipment)
                                    <tr>
                                        <td class="fw-medium">{{ $shipment->shipment_number }}</td>
                                        <td>{{ $shipment->customer->name ?? '-' }}</td>
                                        <td>{{ $shipment->origin_city }} → {{ $shipment->destination_city }}</td>
                                        <td>
                                            @php
                                                $statusBadge = [
                                                    'pending' => 'warning',
                                                    'picked_up' => 'secondary',
                                                    'in_transit' => 'info',
                                                    'delivered' => 'success',
                                                    'cancelled' => 'danger',
                                                ][$shipment->status] ?? 'dark';
                                            @endphp
                                            <span class="badge bg-{{ $statusBadge }}">{{ strtoupper($shipment->status) }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $paymentBadge = [
                                                    'paid' => 'success',
                                                    'partial' => 'warning',
                                                    'unpaid' => 'danger',
                                                ][$shipment->payment_status] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $paymentBadge }}">{{ strtoupper($shipment->payment_status) }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('shipments.show', $shipment) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-3">Belum ada data pengiriman.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-body">
                    <h6 class="card-title">Tracking Cepat</h6>
                    <form method="GET" action="{{ route('dashboard') }}" class="d-flex gap-2">
                        <input type="text" class="form-control" name="tracking_number" value="{{ $trackingNumber ?? '' }}" placeholder="Masukkan No Resi">
                        <button type="submit" class="btn btn-primary">Cek</button>
                    </form>

                    @if (!empty($trackingNumber) && !$trackedShipment)
                        <div class="alert alert-warning mt-3 mb-0 py-2">No resi <strong>{{ $trackingNumber }}</strong> tidak ditemukan.</div>
                    @endif
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-body">
                    <h6 class="card-title">Ringkasan Master Data</h6>
                    <div class="row">
                        <div class="col-6"><small class="text-muted">Cabang</small><div class="fw-bold">{{ $totalBranches ?? 0 }}</div></div>
                        <div class="col-6"><small class="text-muted">Kendaraan</small><div class="fw-bold">{{ $totalVehicles ?? 0 }}</div></div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6"><small class="text-muted">Pelanggan</small><div class="fw-bold">{{ $totalCustomers ?? 0 }}</div></div>
                        <div class="col-6"><small class="text-muted">Pembayaran</small><div class="fw-bold">{{ $paymentCount ?? 0 }}</div></div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Quick Actions</h6>
                    <div class="d-grid gap-2">
                        <a href="{{ route('branches.create') }}" class="btn btn-outline-primary btn-sm">+ Tambah Cabang</a>
                        <a href="{{ route('customers.create') }}" class="btn btn-outline-primary btn-sm">+ Tambah Pelanggan</a>
                        <a href="{{ route('vehicles.create') }}" class="btn btn-outline-primary btn-sm">+ Tambah Kendaraan</a>
                        <a href="{{ route('shipments.create') }}" class="btn btn-success btn-sm">+ Buat Pengiriman</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($trackedShipment)
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Hasil Tracking: {{ $trackedShipment->shipment_number }}</h5>
                            <a href="{{ route('shipments.show', $trackedShipment) }}" class="btn btn-sm btn-primary">Lihat Detail</a>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3"><strong>Status:</strong> {{ strtoupper($trackedShipment->status) }}</div>
                            <div class="col-md-3"><strong>Pengirim:</strong> {{ $trackedShipment->sender_name }}</div>
                            <div class="col-md-3"><strong>Penerima:</strong> {{ $trackedShipment->receiver_name }}</div>
                            <div class="col-md-3"><strong>Rute:</strong> {{ $trackedShipment->origin_city }} → {{ $trackedShipment->destination_city }}</div>
                        </div>

                        <h6>Riwayat Tracking</h6>
                        <ul class="list-group list-group-flush">
                            @forelse ($trackedShipment->trackings as $track)
                                <li class="list-group-item px-0">
                                    <div class="d-flex justify-content-between">
                                        <strong>{{ strtoupper($track->status) }}</strong>
                                        <small class="text-muted">{{ $track->recorded_at ? $track->recorded_at->format('d-m-Y H:i') : '-' }}</small>
                                    </div>
                                    @if ($track->description)
                                        <small class="text-muted">{{ $track->description }}</small>
                                    @endif
                                </li>
                            @empty
                                <li class="list-group-item px-0 text-muted">Belum ada riwayat tracking.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>

@endsection