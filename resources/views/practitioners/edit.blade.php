@extends('layouts.preclinic-app')

@section('content')
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <h4 class="page-title">Edit User</h4>
    </div>
</div>
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <form method="POST" action="{{ route('practitioners.update', $practitioner->id) }}">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Nama Lengkap <span class="text-danger">*</span></label>
                        <input class="form-control @error('full_name') is-invalid @enderror" type="text" name="full_name" value="{{ old('full_name', $practitioner->full_name) }}" required>
                        @error('full_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email', $practitioner->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Identifier (NIP/SIP)</label>
                        <input class="form-control @error('identifier') is-invalid @enderror" type="text" name="identifier" value="{{ old('identifier', $practitioner->identifier) }}">
                        @error('identifier')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Role <span class="text-danger">*</span></label>
                        <select class="select @error('role') is-invalid @enderror" name="role" required>
                            <option value="">Pilih Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{ old('role', $practitioner->roles->first()?->name ?? $practitioner->role) == $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Phone</label>
                        <input class="form-control @error('phone') is-invalid @enderror" type="text" name="phone" value="{{ old('phone', $practitioner->phone) }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Password</label>
                        <input class="form-control @error('password') is-invalid @enderror" type="password" name="password">
                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password</small>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Konfirmasi Password</label>
                        <input class="form-control @error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation">
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="display-block">Status</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="is_active" id="user_active" value="1" {{ old('is_active', $practitioner->is_active) == '1' || (old('is_active') === null && $practitioner->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="user_active">
                        Aktif
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="is_active" id="user_inactive" value="0" {{ old('is_active', $practitioner->is_active) == '0' || (old('is_active') === null && !$practitioner->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="user_inactive">
                        Nonaktif
                    </label>
                </div>
            </div>
            <div class="m-t-20 text-center">
                <button class="btn btn-primary submit-btn" type="submit">Update User</button>
                <a href="{{ route('practitioners.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.select').select2();
    });
</script>
@endpush

