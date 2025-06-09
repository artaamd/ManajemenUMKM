<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleUmkm
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'umkm') {
            return $next($request);
        }

        return redirect('/dashboard')->with('error', 'Akses ditolak. Hanya UMKM yang dapat mengakses halaman ini.');
    }
}