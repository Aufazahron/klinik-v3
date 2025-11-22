<?php

namespace App\Http\Controllers;

use App\Models\Encounter;
use App\Models\Patient;
use App\Models\Practitioner;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EncounterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Bisa tambahkan permission: registration.read, registration.create, dll jika sudah di-define.
    }

    // List antrian hari ini
    public function index(Request $request)
    {
        $today = now()->startOfDay();
        $query = Encounter::with(['patient', 'practitioner', 'department'])
            ->whereDate('encounter_datetime', $today->toDateString())
            ->orderBy('department_id')
            ->orderBy('encounter_code');

        if ($deptId = $request->get('department_id')) {
            $query->where('department_id', $deptId);
        }

        if ($status = $request->get('status')) {
            if ($status !== 'all') {
                $query->where('encounter_status', $status);
            }
        }

        $encounters = $query->paginate(15)->withQueryString();

        $departments = Department::orderBy('name')->get();

        return view('encounters.index', compact('encounters', 'departments'));
    }

    public function create()
    {
        $departments = Department::where('is_active', true)->orderBy('name')->get();
        $doctors = Practitioner::where('role', 'Dokter')
            ->where('is_active', true)
            ->orderBy('full_name')
            ->get();

        return view('encounters.create', compact('departments', 'doctors'));
    }

    protected function generateQueueNumber(int $departmentId, \DateTimeInterface $date, int $tenantId = 1): string
    {
        // Format: [KODE_POLI]-[3 digit urut harian], contoh: GIGI-001
        $dept = Department::find($departmentId);
        $prefix = $dept && $dept->code ? $dept->code : 'Q';

        $lastCode = Encounter::where('tenant_id', $tenantId)
            ->where('department_id', $departmentId)
            ->whereDate('encounter_datetime', $date->format('Y-m-d'))
            ->orderBy('id', 'desc')
            ->value('encounter_code');

        if (!$lastCode) {
            return $prefix . '-001';
        }

        // Ambil angka di belakang prefix
        if (preg_match('/(\d+)$/', $lastCode, $m)) {
            $number = (int) $m[1];
        } else {
            $number = 0;
        }

        $next = $number + 1;
        $suffix = str_pad((string) $next, 3, '0', STR_PAD_LEFT);

        return $prefix . '-' . $suffix;
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => ['required', 'exists:patients,id'],
            'department_id' => ['required', 'exists:departments,id'],
            'practitioner_id' => ['nullable', 'exists:practitioners,id'],
            'chief_complaint' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($request) {
            $tenantId = 1; // sementara
            $now = now();

            $queueNumber = $this->generateQueueNumber($request->department_id, $now, $tenantId);

            Encounter::create([
                'tenant_id' => $tenantId,
                'patient_id' => $request->patient_id,
                'department_id' => $request->department_id,
                'practitioner_id' => $request->practitioner_id,
                'encounter_datetime' => $now,
                'encounter_status' => 'waiting',
                'encounter_code' => $queueNumber,
                'chief_complaint' => $request->chief_complaint,
                'is_active' => true,
            ]);
        });

        return redirect()->route('encounters.index')->with('success', 'Pendaftaran berhasil. Antrian pasien telah dibuat.');
    }

    // Ubah status antrian (dipanggil, selesai, batal, dll)
    public function updateStatus(Request $request, Encounter $encounter)
    {
        $request->validate([
            'status' => ['required', 'in:waiting,called,in_progress,finished,cancelled'],
        ]);

        $encounter->update([
            'encounter_status' => $request->status,
        ]);

        return back()->with('success', 'Status antrian diperbarui.');
    }
}
