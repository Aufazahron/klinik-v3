<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Practitioner;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:practitioners,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['nullable', 'string', 'max:50'], // boleh optional, default nanti diisi "admin" kalau kosong
        ]);

        $practitioner = Practitioner::create([
            'tenant_id' => 1, // sementara hardcode, nanti bisa diganti multi-tenant
            'full_name' => $request->full_name,
            'email' => $request->email,
            'role' => $request->role ?? 'admin',
            'password' => Hash::make($request->password),
            'is_active' => true,
        ]);

        event(new Registered($practitioner));

        Auth::login($practitioner);

        return redirect(route('dashboard', absolute: false));
    }
}
