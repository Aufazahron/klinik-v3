@extends('layouts.preclinic-app')

@section('content')
<div class="row">
    <div class="col-sm-4 col-3">
        <h4 class="page-title">Manajemen Pasien</h4>
    </div>
    <div class="col-sm-8 col-9 text-right m-b-20">
        <a href="{{ route('patients.create') }}" class="btn btn-primary float-right btn-rounded"><i class="fa fa-plus"></i> Pasien Baru</a>
    </div>
</div>
<div class="row filter-row">
    <form method="GET" action="{{ route('patients.index') }}" class="w-100">
        <div class="col-sm-6 col-md-4">
            <div class="form-group form-focus">
                <label class="focus-label">Cari (Nama / No RM / NIK / Telp)</label>
                <input type="text" name="q" class="form-control floating" value="{{ request('q') }}" placeholder="Cari...">
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="form-group form-focus select-focus">
                <label class="focus-label">Status</label>
                <select class="select floating" name="status">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
        </div>
        <div class="col-sm-6 col-md-2">
            <button type="submit" class="btn btn-success btn-block"> <i class="fa fa-search"></i> Cari </button>
        </div>
        <div class="col-sm-6 col-md-2">
            <a href="{{ route('patients.index') }}" class="btn btn-secondary btn-block">Reset</a>
        </div>
    </form>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped custom-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th style="min-width:120px;">No RM</th>
                        <th style="min-width:200px;">Nama</th>
                        <th>Gender</th>
                        <th>Tgl Lahir</th>
                        <th>Telp</th>
                        <th>Status</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $index => $p)
                    <tr>
                        <td>{{ $patients->firstItem() + $index }}</td>
                        <td><strong>{{ $p->medical_record_number }}</strong></td>
                        <td>
                            <h2>{{ $p->full_name }}</h2>
                            @if($p->national_id)
                                <small class="text-muted">NIK: {{ $p->national_id }}</small>
                            @endif
                        </td>
                        <td>{{ $p->gender === 'male' ? 'Laki-laki' : ($p->gender === 'female' ? 'Perempuan' : $p->gender) }}</td>
                        <td>{{ optional($p->birth_date)->format('d-m-Y') }}</td>
                        <td>{{ $p->phone ?? '-' }}</td>
                        <td>
                            @if($p->is_active)
                                <span class="custom-badge status-green">Aktif</span>
                            @else
                                <span class="custom-badge status-red">Nonaktif</span>
                            @endif
                        </td>
                        <td class="text-right">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="{{ route('patients.edit', $p->id) }}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Belum ada data pasien.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-md-12">
                {{ $patients->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection

