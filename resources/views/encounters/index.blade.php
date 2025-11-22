@extends('layouts.preclinic-app')

@section('content')
<div class="page-header">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="page-title">Antrian Poli (Hari Ini)</h3>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5 class="card-title mb-0">Daftar Antrian</h5>
        <a href="{{ route('encounters.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Pendaftaran Baru
        </a>
    </div>
    <div class="card-body">
        <form class="row mb-3" method="GET">
            <div class="col-md-4">
                <select name="department_id" class="form-control">
                    <option value="">Semua Poli</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" @selected(request('department_id') == $dept->id)>
                            {{ $dept->code }} - {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-control">
                    <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="waiting" {{ request('status') === 'waiting' ? 'selected' : '' }}>Waiting</option>
                    <option value="called" {{ request('status') === 'called' ? 'selected' : '' }}>Dipanggil</option>
                    <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>Sedang Dilayani</option>
                    <option value="finished" {{ request('status') === 'finished' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Batal</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-outline-primary w-100" type="submit">Filter</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>No Antrian</th>
                        <th>Poli</th>
                        <th>Pasien</th>
                        <th>Dokter</th>
                        <th>Waktu Daftar</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($encounters as $e)
                        <tr>
                            <td><strong>{{ $e->encounter_code }}</strong></td>
                            <td>{{ $e->department?->name }}</td>
                            <td>
                                <h2 class="table-avatar">{{ $e->patient?->full_name }}</h2>
                                <small class="text-muted">{{ $e->patient?->medical_record_number }}</small>
                            </td>
                            <td>{{ $e->practitioner?->full_name ?? '-' }}</td>
                            <td>{{ optional($e->encounter_datetime)->format('d-m-Y H:i') }}</td>
                            <td>
                                @php
                                    $status = $e->encounter_status;
                                    $label = ucfirst(str_replace('_', ' ', $status));
                                    $class = match($status) {
                                        'waiting' => 'bg-warning',
                                        'called' => 'bg-info',
                                        'in_progress' => 'bg-primary',
                                        'finished' => 'bg-success',
                                        'cancelled' => 'bg-danger',
                                        default => 'bg-secondary',
                                    };
                                @endphp
                                <span class="badge {{ $class }}">{{ $label }}</span>
                            </td>
                            <td class="text-end">
                                <form action="{{ route('encounters.updateStatus', $e) }}" method="POST" class="d-inline">
                                    @csrf
                                    <div class="input-group input-group-sm">
                                        <select name="status" class="form-control">
                                            <option value="waiting" @selected($e->encounter_status === 'waiting')>Waiting</option>
                                            <option value="called" @selected($e->encounter_status === 'called')>Dipanggil</option>
                                            <option value="in_progress" @selected($e->encounter_status === 'in_progress')>Dilayani</option>
                                            <option value="finished" @selected($e->encounter_status === 'finished')>Selesai</option>
                                            <option value="cancelled" @selected($e->encounter_status === 'cancelled')>Batal</option>
                                        </select>
                                        <button class="btn btn-outline-primary" type="submit">Update</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center">Belum ada antrian hari ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $encounters->links() }}
        </div>
    </div>
</div>
@endsection

