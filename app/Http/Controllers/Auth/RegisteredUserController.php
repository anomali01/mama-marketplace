<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('home', absolute: false));
    }

    /**
     * Display the validator registration view.
     */
    public function createValidator(): View
    {
        $prodis = \App\Models\StudyProgram::all();
        return view('auth.register-validator', compact('prodis'));
    }

    /**
     * Handle an incoming validator registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeValidator(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 
                'string', 
                'lowercase', 
                'email', 
                'max:255', 
                'unique:'.User::class,
                'regex:/^[a-zA-Z0-9._%+-]+@student\.[a-zA-Z0-9.-]+\.(ac\.id|co\.id)$/'
            ],
            'nim' => ['required', 'string', 'max:20', 'unique:'.User::class],
            'validator_prodi_id' => ['required', 'exists:prodis,id'],
            'phone' => ['required', 'string', 'max:15'],
            'bank_name' => ['required', 'string', 'max:100'],
            'account_number' => ['required', 'string', 'max:50'],
            'account_holder_name' => ['required', 'string', 'max:150'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'email.regex' => 'Email harus menggunakan domain kampus (@student.namakampus.ac.id atau @student.namakampus.co.id)',
            'nim.unique' => 'NIM sudah terdaftar',
            'validator_prodi_id.required' => 'Program studi harus dipilih',
            'validator_prodi_id.exists' => 'Program studi tidak valid',
        ]);

        // Cek apakah prodi sudah punya validator
        $existingValidator = User::where('role', 'validator')
            ->where('validator_prodi_id', $request->validator_prodi_id)
            ->where('verified', true)
            ->first();

        if ($existingValidator) {
            return back()->withErrors([
                'validator_prodi_id' => 'Program studi ini sudah memiliki validator.'
            ])->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'validator',
            'nim' => $request->nim,
            'validator_prodi_id' => $request->validator_prodi_id,
            'phone' => $request->phone,
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'account_holder_name' => $request->account_holder_name,
            'verified' => false, // Validator perlu diverifikasi admin
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Redirect ke home karena validator belum verified
        return redirect(route('home', absolute: false))
            ->with('success', 'Pendaftaran berhasil! Akun Anda sedang menunggu verifikasi admin. Anda akan mendapat notifikasi melalui email setelah akun diverifikasi.');
    }
}
