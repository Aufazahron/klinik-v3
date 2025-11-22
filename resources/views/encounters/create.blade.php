@extends('layouts.preclinic-app')

@section('content')
<div class="page-header">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="page-title">Pendaftaran Pasien ke Poli</h3>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('encounters.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Pasien <span class="text-danger">*</span></label>
                        {{-- Versi awal: simple select. Next step bisa diganti search modal --}}
                        <select name="patient_id" class="form-control" required>
                            <option value="">-- Pilih Pasien --</option>
                            @foreach(\App\Models\Patient::where('is_active', true)->orderBy('full_name')->limit(100)->get() as $p)
                                <option value="{{ $p->id }}" @selected(old('patient_id') == $p->id)>
                                    {{ $p->medical_record_number }} - {{ $p->full_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('patient_id') <div class="text-danger">{{ $message }}</div> @enderror
                        <small class="form-text text-muted">Jika pasien belum terdaftar, daftarkan dulu di menu Manajemen Pasien.</small>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Poli <span class="text-danger">*</span></label>
                        <select name="department_id" class="form-control" required>
                            <option value="">-- Pilih Poli --</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" @selected(old('department_id') == $dept->id)>
                                    {{ $dept->code }} - {{ $dept->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('department_id') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Dokter (opsional)</label>
                        <select name="practitioner_id" class="form-control">
                            <option value="">-- Belum ditentukan --</option>
                            @foreach($doctors as $d)
                                <option value="{{ $d->id }}" @selected(old('practitioner_id') == $d->id)>
                                    {{ $d->full_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('practitioner_id') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Keluhan Utama</label>
                        <textarea name="chief_complaint" class="form-control" rows="5" placeholder="Masukkan keluhan utama pasien...">{{ old('chief_complaint') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Informasi</label>
                        <p class="form-text text-muted">
                            Nomor antrian akan dibuat otomatis setelah disimpan, berdasarkan poli & tanggal hari ini.
                            Format: [KODE_POLI]-[001], contoh: GIGI-001, IGD-001, dll.
                        </p>
                    </div>
                </div>
            </div>

            <div class="form-group mb-0">
                <a href="{{ route('encounters.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Daftarkan</button>
            </div>
        </form>
    </div>
</div>
@endsection

