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
use Illuminate\Support\Facades\Log;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
{
    try {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'has_nib' => ['required', 'in:yes,no'],
            'nib' => ['required_if:has_nib,yes', 'string', 'max:13', 'nullable'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'akun_facebook' => ['nullable', 'url', 'max:255'],
            'akun_instagram' => ['nullable', 'url', 'max:255'],
            'total_pengikut_facebook' => ['nullable', 'integer', 'min:0'],
            'total_pengikut_instagram' => ['nullable', 'integer', 'min:0'],
            'role' => ['required', 'in:umkm'],
        ]);

        Log::info('Validated data:', $validated);
        Log::info('Request all data:', $request->all());

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'nib' => $validated['has_nib'] === 'yes' ? $validated['nib'] : null,
            'lokasi' => $validated['lokasi'],
            'akun_facebook' => $validated['akun_facebook'],
            'akun_instagram' => $validated['akun_instagram'],
            'total_pengikut_facebook' => $validated['total_pengikut_facebook'] ?? 0,
            'total_pengikut_instagram' => $validated['total_pengikut_instagram'] ?? 0,
        ]);

        Log::info('User created:', ['user_id' => $user->id]);

        event(new Registered($user));

        $loginSuccess = Auth::login($user);

        Log::info('Login attempt:', ['success' => $loginSuccess]);

        return redirect()->route('dashboard')->with('success', 'Registrasi berhasil! Anda telah login.');
    } catch (\Exception $e) {
        Log::error('Registration failed:', ['error' => $e->getMessage()]);
        return redirect()->back()->with('error', 'Registrasi gagal: ' . $e->getMessage());
    }
}
}