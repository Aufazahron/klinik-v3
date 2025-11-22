@csrf
<div class="mb-3">
    <label class="form-label">Nama Poli</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $department->name ?? '') }}" required>
</div>
<div class="mb-3">
    <label class="form-label">Kode Poli</label>
    <input type="text" name="code" class="form-control" value="{{ old('code', $department->code ?? '') }}">
</div>
<div class="mb-3">
    <label class="form-label">Deskripsi</label>
    <textarea name="description" class="form-control">{{ old('description', $department->description ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Organization ID</label>
    <input type="text" name="organization_id" class="form-control" value="{{ old('organization_id', $department->organization_id ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Location ID</label>
    <input type="text" name="location_id" class="form-control" value="{{ old('location_id', $department->location_id ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">External ID</label>
    <input type="text" name="external_id" class="form-control" value="{{ old('external_id', $department->external_id ?? '') }}">
</div>

<div class="mb-3 form-check">
    <input type="checkbox" name="is_active" value="1" class="form-check-input" @checked(old('is_active', $department->is_active ?? true))>
    <label class="form-check-label">Aktif</label>
</div>

<div class="text-end">
    <a href="{{ route('departments.index') }}" class="btn btn-secondary">Batal</a>
    <button type="submit" class="btn btn-primary">Simpan</button>
</div>

