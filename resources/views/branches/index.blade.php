@extends('layouts.app')

@section('title', 'Daftar Cabang')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h2>Daftar Cabang</h2>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('branches.create') }}" class="btn btn-primary">+ Tambah Cabang</a>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Kota</th>
                    <th>Telepon</th>
                    <th>Status</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($branches as $branch)
                    <tr>
                        <td><strong>{{ $branch->code }}</strong></td>
                        <td>{{ $branch->name }}</td>
                        <td>{{ $branch->city ?? '-' }}</td>
                        <td>{{ $branch->phone ?? '-' }}</td>
                        <td>
                            @if ($branch->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('branches.show', $branch) }}" class="btn btn-sm btn-info">Lihat</a>
                            <a href="{{ route('branches.edit', $branch) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('branches.destroy', $branch) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus cabang ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Belum ada cabang</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $branches->links() }}
</div>

@endsection
