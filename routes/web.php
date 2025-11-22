<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PractitionerController;
use App\Http\Controllers\RoleController;
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
});

require __DIR__.'/auth.php';
