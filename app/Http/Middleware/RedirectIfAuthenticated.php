<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();
                if ($user && $user->role === 'admin') { // Tambahkan pengecekan $user
                    return redirect()->route('dashboard');
                }
                if ($user && $user->role === 'umkm') { // Tambahkan pengecekan $user
                    $umkm = \App\Models\Umkm::where('user_id', $user->id)->first();
                    if (!$umkm) {
                        return redirect()->route('umkm.create')->with('error', 'Anda belum memiliki UMKM. Silakan buat UMKM terlebih dahulu.');
                    }
                    return redirect()->route('dashboard');
                }
            }
        }

        return $next($request);
    }
}