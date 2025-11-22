@csrf
<div class="mb-3">
    <label class="form-label">Nama Asuransi</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $insurance->name ?? '') }}" required>
    @error('name') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Tipe</label>
    <select name="type" class="form-control" required>
        <option value="">-- Pilih Tipe --</option>
        @foreach($types as $t)
            <option value="{{ $t }}" @selected(old('type', $insurance->type ?? '') === $t)>{{ strtoupper($t) }}</option>
        @endforeach
    </select>
    @error('type') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Kontak / Info</label>
    <textarea name="contact_info" class="form-control" rows="3">{{ old('contact_info', $insurance->contact_info ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">External ID (opsional)</label>
    <input type="text" name="external_id" class="form-control" value="{{ old('external_id', $insurance->external_id ?? '') }}">
</div>

<div class="mb-3 form-check">
    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" @checked(old('is_active', $insurance->is_active ?? true))>
    <label class="form-check-label" for="is_active">Aktif</label>
</div>

<div class="text-end">
    <a href="{{ route('insurances.index') }}" class="btn btn-secondary">Batal</a>
    <button type="submit" class="btn btn-primary">Simpan</button>
</div>

