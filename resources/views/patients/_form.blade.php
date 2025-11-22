@csrf
<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" name="full_name" class="form-control" value="{{ old('full_name', $patient->full_name ?? '') }}" required>
            @error('full_name') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
            <select name="gender" class="form-control" required>
                <option value="">--Pilih--</option>
                @foreach($genders as $val => $label)
                    <option value="{{ $val }}" @selected(old('gender', $patient->gender ?? '') === $val)>{{ $label }}</option>
                @endforeach
            </select>
            @error('gender') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Tempat Lahir</label>
            <input type="text" name="birth_place" class="form-control" value="{{ old('birth_place', $patient->birth_place ?? '') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
            <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date', optional($patient->birth_date ?? null)->format('Y-m-d')) }}" required>
            @error('birth_date') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Status Perkawinan</label>
            <select name="marital_status" class="form-control">
                <option value="">--Pilih--</option>
                @foreach($maritalStatuses as $code => $label)
                    <option value="{{ $code }}" @selected(old('marital_status', $patient->marital_status ?? '') === $code)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">No. HP</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $patient->phone ?? '') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="address" class="form-control" rows="3">{{ old('address', $patient->address ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">NIK</label>
            <input type="text" name="national_id" class="form-control" value="{{ old('national_id', $patient->national_id ?? '') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">No. KK</label>
            <input type="text" name="family_card_number" class="form-control" value="{{ old('family_card_number', $patient->family_card_number ?? '') }}">
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" @checked(old('is_active', $patient->is_active ?? true))>
            <label class="form-check-label" for="is_active">Aktif</label>
        </div>
    </div>
</div>

<hr>

<h5>Asuransi Utama (Opsional)</h5>
<div class="row">
    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">Asuransi</label>
            <select name="insurance_id" class="form-control">
                <option value="">-- Tanpa Asuransi --</option>
                @foreach($insurances as $ins)
                    <option value="{{ $ins->id }}"
                        @selected(old('insurance_id', optional($primaryInsurance)->insurance_id) == $ins->id)>
                        {{ $ins->name }}
                    </option>
                @endforeach
            </select>
            @error('insurance_id') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">No. Kepesertaan</label>
            <input type="text" name="member_number" class="form-control" value="{{ old('member_number', optional($primaryInsurance)->member_number ?? '') }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">Kelas</label>
            <input type="text" name="insurance_class" class="form-control" value="{{ old('insurance_class', optional($primaryInsurance)->class ?? '') }}">
        </div>
    </div>
</div>

<div class="text-end">
    <a href="{{ route('patients.index') }}" class="btn btn-secondary">Batal</a>
    <button type="submit" class="btn btn-primary">Simpan</button>
</div>

