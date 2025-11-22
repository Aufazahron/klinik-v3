<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    // Middleware sudah diatur di routes/web.php
    // Jika perlu middleware tambahan, bisa ditambahkan di routes atau menggunakan trait

    public function index()
    {
        $roles = Role::where('guard_name', 'web')->orderBy('name')->paginate(10);

        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::where('guard_name', 'web')->get();

        // groupBy module (prefix sebelum titik)
        $grouped = $permissions->groupBy(function ($perm) {
            return explode('.', $perm->name)[0];
        });

        $modules = [
            'user'      => 'User Management',
            'poli'      => 'Poli',
            'doctor'    => 'Dokter',
            'insurance' => 'Asuransi',
            'queue'     => 'Antrian',
        ];

        return view('roles.create', [
            'modules' => $modules,
            'groupedPermissions' => $grouped,
            'role' => null,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:roles,name,NULL,id,guard_name,web'],
            'permissions' => ['array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        // Convert permission IDs to Permission objects
        if ($request->filled('permissions')) {
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            $role->syncPermissions($permissions);
        } else {
            $role->syncPermissions([]);
        }

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role berhasil dibuat.');
    }

    public function edit(Role $role)
    {
        if ($role->guard_name !== 'web') {
            abort(404);
        }

        $permissions = Permission::where('guard_name', 'web')->get();

        $grouped = $permissions->groupBy(function ($perm) {
            return explode('.', $perm->name)[0];
        });

        $modules = [
            'user'      => 'User Management',
            'poli'      => 'Poli',
            'doctor'    => 'Dokter',
            'insurance' => 'Asuransi',
            'queue'     => 'Antrian',
        ];

        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('roles.edit', [
            'role' => $role,
            'modules' => $modules,
            'groupedPermissions' => $grouped,
            'rolePermissions' => $rolePermissions,
        ]);
    }

    public function update(Request $request, Role $role)
    {
        if ($role->guard_name !== 'web') {
            abort(404);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:roles,name,'.$role->id.',id,guard_name,web'],
            'permissions' => ['array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        $role->update([
            'name' => $request->name,
        ]);

        // Convert permission IDs to Permission objects
        if ($request->filled('permissions')) {
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            $role->syncPermissions($permissions);
        } else {
            $role->syncPermissions([]);
        }

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role berhasil diperbarui.');
    }

    public function destroy(Role $role)
    {
        if ($role->guard_name !== 'web') {
            abort(404);
        }

        // Optional: cek kalau role admin tidak boleh dihapus
        if ($role->name === 'admin') {
            return back()->with('error', 'Role admin tidak boleh dihapus.');
        }

        $role->delete();

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role berhasil dihapus.');
    }
}
