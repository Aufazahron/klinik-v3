@csrf

<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="form-group">
            <label>Role Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $role->name ?? '') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="form-group">
            <div class="form-check">
                <input type="checkbox" id="admin-access" class="form-check-input" />
                <label class="form-check-label" for="admin-access">Administrator Access</label>
            </div>
            <!-- <small class="form-text text-muted">Centang untuk memilih semua permission (hanya efek di UI).</small> -->
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Module</th>
                        <th class="text-center">Delete</th>
                        <th class="text-center">Read</th>
                        <th class="text-center">Update</th>
                        <th class="text-center">Create</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $actions = ['delete', 'read', 'update', 'create'];
                    @endphp
                    @foreach($modules as $moduleKey => $moduleLabel)
                        <tr>
                            <td><strong>{{ $moduleLabel }}</strong></td>
                            @foreach($actions as $action)
                                @php
                                    // permission name: "module.action"
                                    $permName = $moduleKey.'.'.$action;
                                    $perm = $groupedPermissions[$moduleKey] ?? collect();
                                    $perm = $perm->firstWhere('name', $permName);
                                @endphp
                                <td class="text-center">
                                    @if($perm)
                                        <input
                                            type="checkbox"
                                            class="form-check-input permission-checkbox"
                                            name="permissions[]"
                                            value="{{ $perm->id }}"
                                            @if(isset($rolePermissions) && in_array($perm->id, $rolePermissions)) checked @endif
                                        >
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="m-t-20 text-center">
            <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary submit-btn">Submit</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const adminCheckbox = document.getElementById('admin-access');
        if (adminCheckbox) {
            adminCheckbox.addEventListener('change', function () {
                const checked = this.checked;
                document.querySelectorAll('.permission-checkbox').forEach(cb => {
                    cb.checked = checked;
                });
            });
        }
    });
</script>
@endpush

