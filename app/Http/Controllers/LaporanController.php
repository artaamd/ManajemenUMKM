<?php

namespace App\Http\Controllers;

use App\Models\User;
use Barryvdh\DomPDF\Facade\PDF;
use App\Models\Konten;
use App\Exports\UmkmKontenExport;
use App\Exports\DaftarUmkmExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function umkm()
    {
        $umkms = User::where('role', 'umkm')->get();
        return view('laporan.umkm', compact('umkms'));
    }

    public function grade()
    {
        $umkms = User::where('role', 'umkm')->with(['kontens', 'kontens.analitik'])->get(); // Ubah 'konten' menjadi 'kontens'
        return view('laporan.grade', compact('umkms'));
    }

    public function show($umkmId)
    {
        $selectedUmkm = User::where('id', $umkmId)->where('role', 'umkm')->with(['kontens', 'kontens.analitik'])->firstOrFail();
        $kontens = $selectedUmkm->kontens()->with('analitik')->get(); // Ubah 'konten' menjadi 'kontens'
        $umkms = User::where('role', 'umkm')->with(['kontens', 'kontens.analitik'])->get(); // Ubah 'konten' menjadi 'kontens'
        return view('laporan.grade', compact('umkms', 'kontens', 'selectedUmkm'));
    }

    public function cetakUmkmPdf()
    {
        $umkms = User::where('role', 'umkm')->get();
        $html = view('laporan.umkm-pdf', compact('umkms'))->render();
        $pdf = PDF::loadHTML($html);
        return $pdf->download('laporan_daftar_umkm_'.date('d_m_Y').'.pdf');
    }

    public function cetakGradePdf()
    {
        $umkms = User::where('role', 'umkm')->with(['kontens', 'kontens.analitik'])->get(); // Ubah 'konten' menjadi 'kontens'
        $html = view('laporan.grade-pdf', compact('umkms'))->render();
        $pdf = PDF::loadHTML($html);
        return $pdf->download('laporan_grade_umkm_'.date('d_m_Y').'.pdf');
    }

    public function cetakGradePdfPerUmkm($umkmId)
    {
        $umkm = User::where('id', $umkmId)->where('role', 'umkm')->with(['kontens', 'kontens.analitik'])->firstOrFail();
        $kontens = $umkm->kontens()->with('analitik')->get(); // Ubah 'konten' menjadi 'kontens'
        $html = view('laporan.grade-per-umkm-pdf', compact('umkm', 'kontens'))->render();
        $pdf = PDF::loadHTML($html);
        return $pdf->download('laporan_grade_umkm_' . ($umkm->nama_usaha ?? $umkm->name ?? 'umkm') . '_' . date('d_m_Y') . '.pdf');
    }

    public function cetakExcelPerUmkm($umkmId)
    {
        $umkm = User::where('id', $umkmId)->where('role', 'umkm')->firstOrFail();
        $fileName = 'laporan_konten_umkm_' . ($umkm->nama_usaha ?? $umkm->name ?? 'umkm') . '_' . date('d_m_Y') . '.xlsx';
        return Excel::download(new UmkmKontenExport($umkmId), $fileName);
    }

    public function cetakUmkmExcel()
    {
        $fileName = 'laporan_daftar_umkm_' . date('d_m_Y') . '.xlsx';
        return Excel::download(new DaftarUmkmExport(), $fileName);
    }
}