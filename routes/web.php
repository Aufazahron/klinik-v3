<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PractitionerController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\EncounterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Practitioner management routes
    Route::resource('practitioners', PractitionerController::class)->except(['show', 'destroy']);
    Route::post('practitioners/{practitioner}/toggle-status', [PractitionerController::class, 'toggleStatus'])->name('practitioners.toggle-status');

    // Role management routes
    Route::resource('roles', RoleController::class)->except(['show']);

    // Insurance management routes
    Route::resource('insurances', InsuranceController::class)->except(['show']);

    // Department management routes
    Route::resource('departments', DepartmentController::class)->except(['show']);

    // Patient management routes
    Route::resource('patients', PatientController::class)->except(['show', 'destroy']);

    // Encounter (Pendaftaran & Antrian) routes
    Route::get('encounters', [EncounterController::class, 'index'])->name('encounters.index');
    Route::get('encounters/create', [EncounterController::class, 'create'])->name('encounters.create');
    Route::post('encounters', [EncounterController::class, 'store'])->name('encounters.store');
    Route::post('encounters/{encounter}/status', [EncounterController::class, 'updateStatus'])->name('encounters.updateStatus');
});

require __DIR__.'/auth.php';
