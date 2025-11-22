<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // aktifkan permission jika sudah siap:
        // $this->middleware('permission:department.read')->only('index');
    }

    public function index(Request $request)
    {
        $query = Department::query()->orderBy('name');

        if ($search = $request->get('q')) {
            $query->where('name', 'ilike', "%{$search}%")
                  ->orWhere('code', 'ilike', "%{$search}%");
        }

        $departments = $query->paginate(10)->withQueryString();

        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'code' => 'nullable|max:20',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        Department::create([
            'tenant_id' => 1, // untuk saat ini dibuat default
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active', true),
            'organization_id' => $request->organization_id,
            'location_id' => $request->location_id,
            'external_id' => $request->external_id,
        ]);

        return redirect()->route('departments.index')->with('success', 'Poli berhasil ditambahkan.');
    }

    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|max:100',
            'code' => 'nullable|max:20',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $department->update([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active', true),
            'organization_id' => $request->organization_id,
            'location_id' => $request->location_id,
            'external_id' => $request->external_id,
        ]);

        return redirect()->route('departments.index')->with('success', 'Poli berhasil diperbarui.');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('departments.index')->with('success', 'Poli berhasil dihapus.');
    }
}
