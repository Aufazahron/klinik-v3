<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\PatientInsurance;
use App\Models\Insurance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Patient::query()->orderBy('full_name');

        if ($search = $request->get('q')) {
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(full_name) LIKE ?', ['%' . strtolower($search) . '%'])
                  ->orWhereRaw('LOWER(medical_record_number) LIKE ?', ['%' . strtolower($search) . '%'])
                  ->orWhereRaw('LOWER(phone) LIKE ?', ['%' . strtolower($search) . '%'])
                  ->orWhereRaw('LOWER(national_id) LIKE ?', ['%' . strtolower($search) . '%']);
            });
        }

        if ($status = $request->get('status')) {
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $patients = $query->paginate(10)->withQueryString();

        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        $genders = [
            'male' => 'Laki-laki',
            'female' => 'Perempuan',
        ];

        $maritalStatuses = [
            'S' => 'Single',
            'M' => 'Menikah',
            'D' => 'Cerai',
            'W' => 'Janda/Duda',
        ];

        $insurances = Insurance::where('is_active', true)->orderBy('name')->get();

        return view('patients.create', compact('genders', 'maritalStatuses', 'insurances'));
    }

    protected function generateMedicalRecordNumber(int $tenantId = 1): string
    {
        $lastMrn = Patient::where('tenant_id', $tenantId)
            ->orderBy('id', 'desc')
            ->value('medical_record_number');

        if (!$lastMrn) {
            return '000001';
        }

        // Ambil angka di akhir, fallback kalau formatnya beda
        $number = (int) preg_replace('/\D/', '', $lastMrn);
        $next = $number + 1;

        return str_pad((string) $next, 6, '0', STR_PAD_LEFT);
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => ['required', 'string', 'max:100'],
            'gender' => ['required', 'in:male,female'],
            'birth_place' => ['nullable', 'string', 'max:100'],
            'birth_date' => ['required', 'date'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'national_id' => ['nullable', 'string', 'max:20'],
            'family_card_number' => ['nullable', 'string', 'max:20'],
            'marital_status' => ['nullable', 'in:S,M,D,W'],
            'insurance_id' => ['nullable', 'exists:insurances,id'],
            'member_number' => ['nullable', 'string', 'max:50'],
            'insurance_class' => ['nullable', 'string', 'max:20'],
        ]);

        DB::transaction(function () use ($request) {
            $tenantId = 1; // sementara fixed

            $mrn = $this->generateMedicalRecordNumber($tenantId);

            $patient = Patient::create([
                'tenant_id' => $tenantId,
                'medical_record_number' => $mrn,
                'full_name' => $request->full_name,
                'gender' => $request->gender,
                'birth_place' => $request->birth_place,
                'birth_date' => $request->birth_date,
                'phone' => $request->phone,
                'address' => $request->address,
                'national_id' => $request->national_id,
                'family_card_number' => $request->family_card_number,
                'marital_status' => $request->marital_status,
                'registered_at' => now(),
                'is_active' => $request->boolean('is_active', true),
            ]);

            if ($request->filled('insurance_id')) {
                PatientInsurance::create([
                    'tenant_id' => $tenantId,
                    'patient_id' => $patient->id,
                    'insurance_id' => $request->insurance_id,
                    'member_number' => $request->member_number,
                    'class' => $request->insurance_class,
                    'active' => true,
                ]);
            }
        });

        return redirect()->route('patients.index')->with('success', 'Pasien berhasil ditambahkan.');
    }

    public function edit(Patient $patient)
    {
        $genders = [
            'male' => 'Laki-laki',
            'female' => 'Perempuan',
        ];

        $maritalStatuses = [
            'S' => 'Single',
            'M' => 'Menikah',
            'D' => 'Cerai',
            'W' => 'Janda/Duda',
        ];

        $insurances = Insurance::where('is_active', true)->orderBy('name')->get();
        $primaryInsurance = $patient->primaryInsurance;

        return view('patients.edit', compact('patient', 'genders', 'maritalStatuses', 'insurances', 'primaryInsurance'));
    }

    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'full_name' => ['required', 'string', 'max:100'],
            'gender' => ['required', 'in:male,female'],
            'birth_place' => ['nullable', 'string', 'max:100'],
            'birth_date' => ['required', 'date'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'national_id' => ['nullable', 'string', 'max:20'],
            'family_card_number' => ['nullable', 'string', 'max:20'],
            'marital_status' => ['nullable', 'in:S,M,D,W'],
            'insurance_id' => ['nullable', 'exists:insurances,id'],
            'member_number' => ['nullable', 'string', 'max:50'],
            'insurance_class' => ['nullable', 'string', 'max:20'],
        ]);

        DB::transaction(function () use ($request, $patient) {
            $patient->update([
                'full_name' => $request->full_name,
                'gender' => $request->gender,
                'birth_place' => $request->birth_place,
                'birth_date' => $request->birth_date,
                'phone' => $request->phone,
                'address' => $request->address,
                'national_id' => $request->national_id,
                'family_card_number' => $request->family_card_number,
                'marital_status' => $request->marital_status,
                'is_active' => $request->boolean('is_active', true),
            ]);

            if ($request->filled('insurance_id')) {
                $pi = $patient->primaryInsurance;

                if ($pi) {
                    $pi->update([
                        'insurance_id' => $request->insurance_id,
                        'member_number' => $request->member_number,
                        'class' => $request->insurance_class,
                        'active' => true,
                    ]);
                } else {
                    PatientInsurance::create([
                        'tenant_id' => $patient->tenant_id,
                        'patient_id' => $patient->id,
                        'insurance_id' => $request->insurance_id,
                        'member_number' => $request->member_number,
                        'class' => $request->insurance_class,
                        'active' => true,
                    ]);
                }
            }
        });

        return redirect()->route('patients.index')->with('success', 'Data pasien berhasil diperbarui.');
    }
}
