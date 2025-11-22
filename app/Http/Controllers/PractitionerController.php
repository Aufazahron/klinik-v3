<?php

namespace App\Http\Controllers;

use App\Models\Practitioner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class PractitionerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Practitioner::query();

        // Search functionality
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role (Spatie)
        if ($request->filled('role')) {
            $query->role($request->role);
        }

        $practitioners = $query->orderBy('created_at', 'desc')->paginate(15);
        $roles = Role::where('guard_name', 'web')->orderBy('name')->get();

        return view('practitioners.index', compact('practitioners', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::where('guard_name', 'web')->orderBy('name')->get();
        return view('practitioners.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'full_name' => ['required', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:100'],
            'identifier' => ['nullable', 'string', 'max:50'],
            'role' => ['required', 'exists:roles,name'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', 'min:6'],
            'is_active' => ['nullable', 'boolean'],
        ];

        // Add unique validation only if email is provided
        if ($request->filled('email')) {
            $rules['email'][] = 'unique:practitioners,email';
        }

        // Add unique validation only if identifier is provided
        if ($request->filled('identifier')) {
            $rules['identifier'][] = 'unique:practitioners,identifier';
        }

        $validated = $request->validate($rules);

        $practitioner = Practitioner::create([
            'tenant_id' => 1, // sementara hardcode
            'full_name' => $validated['full_name'],
            'email' => $validated['email'] ?? null,
            'identifier' => $validated['identifier'] ?? null,
            'role' => $validated['role'], // tetap simpan di kolom role untuk backward compatibility
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'is_active' => $request->boolean('is_active', true),
        ]);

        // Assign role menggunakan Spatie Permission
        $practitioner->assignRole($validated['role']);

        return redirect()->route('practitioners.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Practitioner $practitioner)
    {
        $roles = Role::where('guard_name', 'web')->orderBy('name')->get();
        return view('practitioners.edit', compact('practitioner', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Practitioner $practitioner)
    {
        $rules = [
            'full_name' => ['required', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:100'],
            'identifier' => ['nullable', 'string', 'max:50'],
            'role' => ['required', 'exists:roles,name'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'confirmed', 'min:6'],
            'is_active' => ['nullable', 'boolean'],
        ];

        // Add unique validation only if email is provided
        if ($request->filled('email')) {
            $rules['email'][] = 'unique:practitioners,email,'.$practitioner->id;
        }

        // Add unique validation only if identifier is provided
        if ($request->filled('identifier')) {
            $rules['identifier'][] = 'unique:practitioners,identifier,'.$practitioner->id;
        }

        $validated = $request->validate($rules);

        $practitioner->full_name = $validated['full_name'];
        $practitioner->email = $validated['email'] ?? null;
        $practitioner->identifier = $validated['identifier'] ?? null;
        $practitioner->role = $validated['role']; // tetap simpan di kolom role untuk backward compatibility
        $practitioner->phone = $validated['phone'] ?? null;
        $practitioner->is_active = $request->boolean('is_active');

        // Update password only if provided
        if (!empty($validated['password'])) {
            $practitioner->password = Hash::make($validated['password']);
        }

        $practitioner->save();

        // Sync role menggunakan Spatie Permission (hanya 1 role per user)
        $practitioner->syncRoles([$validated['role']]);

        return redirect()->route('practitioners.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Toggle active status
     */
    public function toggleStatus(Practitioner $practitioner)
    {
        $practitioner->is_active = !$practitioner->is_active;
        $practitioner->save();

        return back()->with('success', 'Status user diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Practitioner $practitioner)
    {
        // Soft deactivation instead of hard delete
        abort(403, 'Delete permanen tidak diizinkan. Gunakan toggle status untuk menonaktifkan user.');
    }
}
