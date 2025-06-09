<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (Auth::check() && Auth::user()->role === $role) {
            return $next($request);
        }

        return redirect('/dashboard')->with('error', 'Akses ditolak. Anda tidak memiliki peran yang sesuai untuk mengakses halaman ini.');
    }
}