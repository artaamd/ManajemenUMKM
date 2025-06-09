<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        return redirect('/dashboard')->with('error', 'Akses ditolak. Hanya admin yang dapat mengakses halaman ini.');
    }
}