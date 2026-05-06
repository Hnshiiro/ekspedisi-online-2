@extends('layouts.app')

@section('title', 'Detail Pengiriman - ' . $shipment->shipment_number)

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h2>{{ $shipment->shipment_number }}</h2>
        <p class="text-muted mb-0">{{ $shipment->customer->name ?? '-' }}</p>
    </div>
    <div class="col-md-4 text-end">
        @if ($shipment->status !== 'pending')
            <span class="badge bg-secondary">Tidak bisa diubah</span>
        @else
            <a href="{{ route('shipments.edit', $shipment) }}" class="btn btn-warning">Edit</a>
        @endif
        <a href="{{ route('shipments.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>

<div class="row">
    <!-- Main Info -->
    <div class="col-md-8">
        <!-- Status Card -->
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-1"><small class="text-muted">Status Pengiriman</small></p>
                        @php
                            $statusColors = [
                                'pending' => 'warning',
                                'picked_up' => 'info',
                                'in_transit' => 'primary',
                                'delivered' => 'success',
                                'cancelled' => 'danger',
                            ];
                            $statusLabels = [
                                'pending' => 'Pending',
                                'picked_up' => 'Diambil',
                                'in_transit' => 'Dalam Pengiriman',
                                'delivered' => 'Dikirim',
                                'cancelled' => 'Dibatalkan',
                            ];
                        @endphp
                        <h5>
                            <span class="badge bg-{{ $statusColors[$shipment->status] ?? 'secondary' }}">
                                {{ $statusLabels[$shipment->status] ?? $shipment->status }}
                            </span>
                        </h5>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><small class="text-muted">Status Pembayaran</small></p>
                        @php
                            $paymentColors = [
                                'paid' => 'success',
                                'unpaid' => 'warning',
                                'partial' => 'info',
                            ];
                        @endphp
                        <h5>
                            <span class="badge bg-{{ $paymentColors[$shipment->payment_status] ?? 'secondary' }}">
                                {{ ucfirst(str_replace('_', ' ', $shipment->payment_status)) }}
                            </span>
                        </h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shipment Details -->
        <div class="card mb-3">
            <div class="card-header">
                <h6 class="mb-0">Informasi Pengiriman</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-2">
                            <strong>Pengirim:</strong><br>
                            {{ $shipment->sender_name }}<br>
                            {{ $shipment->sender_phone }}<br>
                            <small>{{ $shipment->sender_address }}<br>{{ $shipment->origin_city }}</small>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2">
                            <strong>Penerima:</strong><br>
                            {{ $shipment->receiver_name }}<br>
                            {{ $shipment->receiver_phone }}<br>
                            <small>{{ $shipment->receiver_address }}<br>{{ $shipment->destination_city }}</small>
                        </p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <p>
                            <strong>Jumlah Paket:</strong><br>
                            {{ $shipment->package_count }} paket
                        </p>
                    </div>
                    <div class="col-md-3">
                        <p>
                            <strong>Berat Total:</strong><br>
                            {{ number_format($shipment->total_weight, 2) }} kg
                        </p>
                    </div>
                    <div class="col-md-3">
                        <p>
                            <strong>Tanggal Pengiriman:</strong><br>
                            {{ $shipment->shipment_date->format('d-m-Y') }}
                        </p>
                    </div>
                    <div class="col-md-3">
                        <p>
                            <strong>Est. Pengiriman:</strong><br>
                            {{ $shipment->estimated_delivery_date->format('d-m-Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cost Breakdown -->
        <div class="card mb-3">
            <div class="card-header">
                <h6 class="mb-0">Rincian Biaya</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <tr>
                        <td>Subtotal</td>
                        <td class="text-end">Rp {{ number_format($shipment->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Biaya Pengiriman</td>
                        <td class="text-end">Rp {{ number_format($shipment->shipping_cost, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="table-active fw-bold">
                        <td>Total</td>
                        <td class="text-end">Rp {{ number_format($shipment->total_amount, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Update Status Form -->
        @if ($shipment->status !== 'delivered' && $shipment->status !== 'cancelled')
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">Update Status</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('shipments.updateStatus', $shipment) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <select class="form-control @error('status') is-invalid @enderror" name="status" required>
                                    <option value="">-- Pilih Status --</option>
                                    @if ($shipment->status === 'pending')
                                        <option value="picked_up">Diambil</option>
                                    @elseif ($shipment->status === 'picked_up')
                                        <option value="in_transit">Dalam Pengiriman</option>
                                    @elseif ($shipment->status === 'in_transit')
                                        <option value="delivered">Dikirim</option>
                                    @endif
                                    <option value="cancelled">Dibatalkan</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary w-100">Update Status</button>
                            </div>
                        </div>
                        <div class="mt-2">
                            <textarea class="form-control" name="notes" placeholder="Catatan (opsional)" rows="2"></textarea>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>

    <!-- Right Sidebar -->
    <div class="col-md-4">
        <!-- Tracking Timeline -->
        <div class="card mb-3">
            <div class="card-header">
                <h6 class="mb-0">Tracking</h6>
            </div>
            <div class="card-body">
                @forelse ($shipment->trackings as $track)
                    <div class="mb-3 pb-3 border-bottom">
                        <p class="mb-1">
                            <strong>{{ $track->status }}</strong><br>
                            <small class="text-muted">{{ $track->recorded_at->format('d-m-Y H:i') }}</small>
                        </p>
                        @if ($track->description)
                            <p class="mb-0 small">{{ $track->description }}</p>
                        @endif
                    </div>
                @empty
                    <p class="text-muted text-center mb-0">Belum ada tracking</p>
                @endforelse
            </div>
        </div>

        <!-- Vehicle & Branch Info -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Operasional</h6>
            </div>
            <div class="card-body">
                <p class="mb-2">
                    <strong>Cabang:</strong><br>
                    {{ $shipment->branch->name ?? '-' }}
                </p>
                @if ($shipment->vehicle)
                    <p class="mb-2">
                        <strong>Kendaraan:</strong><br>
                        {{ $shipment->vehicle->plate_number }}<br>
                        <small>{{ $shipment->vehicle->driver_name ?? '-' }}</small>
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
