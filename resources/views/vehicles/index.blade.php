@extends('layouts.app')

@section('title', 'Daftar Kendaraan')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h2>Daftar Kendaraan</h2>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('vehicles.create') }}" class="btn btn-primary">+ Tambah Kendaraan</a>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Plat Nomor</th>
                    <th>Tipe</th>
                    <th>Pengemudi</th>
                    <th>Cabang</th>
                    <th>Kapasitas</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($vehicles as $vehicle)
                    <tr>
                        <td><strong>{{ $vehicle->plate_number }}</strong></td>
                        <td>{{ $vehicle->vehicle_type ?? '-' }}</td>
                        <td>{{ $vehicle->driver_name ?? '-' }}</td>
                        <td>{{ $vehicle->branch->name ?? '-' }}</td>
                        <td>{{ $vehicle->capacity_kg ? number_format($vehicle->capacity_kg) . ' kg' : '-' }}</td>
                        <td>
                            <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Belum ada kendaraan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $vehicles->links() }}
</div>

@endsection
