@extends('layouts.preclinic-app')

@section('content')
<div class="page-header">
    <div class="row">
        <div class="col-sm-12"><h3 class="page-title">Manajemen Poli</h3></div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5 class="card-title mb-0">Daftar Poli</h5>
        <a href="{{ route('departments.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Poli Baru</a>
    </div>
    <div class="card-body">
        <form class="row mb-3" method="GET">
            <div class="col-md-4">
                <input type="text" name="q" class="form-control" placeholder="Cari poli..." value="{{ request('q') }}">
            </div>
            <div class="col-md-2">
                <button class="btn btn-outline-primary w-100" type="submit">Cari</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Status</th>
                        <th>Org ID</th>
                        <th>Loc ID</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($departments as $d)
                    <tr>
                        <td>{{ $d->code }}</td>
                        <td>{{ $d->name }}</td>
                        <td>
                            @if($d->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-danger">Nonaktif</span>
                            @endif
                        </td>
                        <td>{{ $d->organization_id }}</td>
                        <td>{{ $d->location_id }}</td>
                        <td class="text-end">
                            <a href="{{ route('departments.edit', $d) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('departments.destroy', $d) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus Poli?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                        <tr><td colspan="6">Belum ada data poli.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $departments->links() }}
    </div>
</div>
@endsection

