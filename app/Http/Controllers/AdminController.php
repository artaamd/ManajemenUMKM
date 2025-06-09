<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function laporanDaftarUmkm()
    {
        $umkms = User::where('role', 'umkm')->get();
        return view('laporan.umkm', compact('umkms'));
    }

    public function laporanGradeUmkm()
    {
        return view('laporan.grade');
    }
}