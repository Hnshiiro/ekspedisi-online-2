@extends('layouts.app')

@section('title', 'Daftar Pengiriman')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h2>Daftar Pengiriman</h2>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('shipments.create') }}" class="btn btn-success">+ Buat Pengiriman</a>
    </div>
</div>

<!-- Filter Card -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('shipments.index') }}" class="row g-3">
            <div class="col-md-4">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status" name="status">
                    <option value="">-- Semua Status --</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="picked_up" {{ request('status') == 'picked_up' ? 'selected' : '' }}>Diambil</option>
                    <option value="in_transit" {{ request('status') == 'in_transit' ? 'selected' : '' }}>Dalam Pengiriman</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Dikirim</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="branch_id" class="form-label">Cabang</label>
                <select class="form-control" id="branch_id" name="branch_id">
                    <option value="">-- Semua Cabang --</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">Filter</button>
                <a href="{{ route('shipments.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Shipments Table -->
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>No. Pengiriman</th>
                    <th>Pelanggan</th>
                    <th>Rute</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Bayar</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($shipments as $shipment)
                    <tr>
                        <td>
                            <strong>{{ $shipment->shipment_number }}</strong><br>
                            <small class="text-muted">{{ $shipment->branch->code ?? '-' }}</small>
                        </td>
                        <td>
                            {{ $shipment->customer->name ?? '-' }}<br>
                            <small class="text-muted">{{ $shipment->customer->phone ?? '' }}</small>
                        </td>
                        <td>
                            {{ $shipment->origin_city }} → {{ $shipment->destination_city }}
                        </td>
                        <td>
                            {{ $shipment->shipment_date->format('d-m-Y') }}
                        </td>
                        <td>
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
                            <span class="badge bg-{{ $statusColors[$shipment->status] ?? 'secondary' }}">
                                {{ $statusLabels[$shipment->status] ?? $shipment->status }}
                            </span>
                        </td>
                        <td>
                            @php
                                $paymentColors = [
                                    'paid' => 'success',
                                    'unpaid' => 'warning',
                                    'partial' => 'info',
                                ];
                            @endphp
                            <span class="badge bg-{{ $paymentColors[$shipment->payment_status] ?? 'secondary' }}">
                                {{ ucfirst(str_replace('_', ' ', $shipment->payment_status)) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('shipments.show', $shipment) }}" class="btn btn-sm btn-info">Lihat</a>
                            @if ($shipment->status === 'pending')
                                <a href="{{ route('shipments.edit', $shipment) }}" class="btn btn-sm btn-warning">Edit</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Belum ada pengiriman</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $shipments->links() }}
</div>

@endsection
