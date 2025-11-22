<?php

namespace App\Http\Controllers;

use App\Models\Insurance;
use Illuminate\Http\Request;

class InsuranceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // kalau mau batasi:
        // $this->middleware('permission:insurance.read')->only('index');
        // $this->middleware('permission:insurance.create')->only(['create','store']);
        // $this->middleware('permission:insurance.update')->only(['edit','update']);
    }

    public function index(Request $request)
    {
        $query = Insurance::query()->orderBy('created_at', 'desc');

        if ($search = $request->get('q')) {
            $query->whereRaw('name ILIKE ?', ["%{$search}%"]);
        }

        if ($type = $request->get('type')) {
            $query->where('type', $type);
        }

        $insurances = $query->paginate(10)->withQueryString();

        $types = ['bpjs', 'private', 'company', 'selfpay'];

        return view('insurances.index', compact('insurances', 'types'));
    }

    public function create()
    {
        $types = ['bpjs', 'private', 'company', 'selfpay'];

        return view('insurances.create', compact('types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'type' => ['required', 'in:bpjs,private,company,selfpay'],
            'contact_info' => ['nullable', 'string'],
            'external_id' => ['nullable', 'string', 'max:64'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        Insurance::create([
            'tenant_id' => 1, // sementara hardcode
            'name' => $request->name,
            'type' => $request->type,
            'contact_info' => $request->contact_info,
            'external_id' => $request->external_id,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('insurances.index')->with('success', 'Asuransi berhasil ditambahkan.');
    }

    public function edit(Insurance $insurance)
    {
        $types = ['bpjs', 'private', 'company', 'selfpay'];

        return view('insurances.edit', compact('insurance', 'types'));
    }

    public function update(Request $request, Insurance $insurance)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'type' => ['required', 'in:bpjs,private,company,selfpay'],
            'contact_info' => ['nullable', 'string'],
            'external_id' => ['nullable', 'string', 'max:64'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $insurance->update([
            'name' => $request->name,
            'type' => $request->type,
            'contact_info' => $request->contact_info,
            'external_id' => $request->external_id,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('insurances.index')->with('success', 'Asuransi berhasil diperbarui.');
    }

    public function destroy(Insurance $insurance)
    {
        // kalau tidak mau hard delete, bisa abort(403) atau hanya nonaktifkan
        $insurance->delete();

        return redirect()->route('insurances.index')->with('success', 'Asuransi berhasil dihapus.');
    }
}
