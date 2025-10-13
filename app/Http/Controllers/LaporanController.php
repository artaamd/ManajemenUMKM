<?php

namespace App\Http\Controllers;

use App\Models\User;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Http\Request; // Pastikan ini di-import
use App\Models\Konten;
use App\Exports\UmkmKontenExport;
use App\Exports\DaftarUmkmExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    /**
     * Menampilkan halaman laporan daftar UMKM dengan filter dan pencarian.
     */
    public function umkm(Request $request)
    {
        $lokasiOptions = [
            'Kota Tengah', 'Kota Selatan', 'Kota Barat', 'Kota Timur',
            'Hulonthalangi', 'Dungingi', 'Dumbo Raya', 'Kota Utara', 'Sipatana'
        ];

        $query = User::where('role', 'umkm');

        // 1. Logika untuk Search Bar (nama, email, ATAU NIB)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('nib', 'like', '%' . $search . '%');
            });
        }

        // 2. Logika untuk Filter Lokasi
        if ($request->filled('lokasi')) {
            $query->where('lokasi', $request->input('lokasi'));
        }
        
        // 3. Logika untuk Filter Status NIB
        if ($request->filled('status_nib')) {
            if ($request->input('status_nib') === 'ber-nib') {
                $query->whereNotNull('nib')->where('nib', '!=', '');
            } elseif ($request->input('status_nib') === 'tidak-ber-nib') {
                $query->where(function ($q) {
                    $q->whereNull('nib')->orWhere('nib', '');
                });
            }
        }
        
        $umkms = $query->latest()->get();

        return view('laporan.umkm', [
            'umkms' => $umkms,
            'lokasiOptions' => $lokasiOptions,
            'selectedLokasi' => $request->input('lokasi'),
            'selectedNibStatus' => $request->input('status_nib'),
            'searchTerm' => $request->input('search'),
        ]);
    }

    /**
     * Menampilkan halaman laporan grade konten dengan filter dan pencarian.
     */
    public function grade(Request $request)
    {
        $lokasiOptions = [
            'Kota Tengah', 'Kota Selatan', 'Kota Barat', 'Kota Timur',
            'Hulonthalangi', 'Dungingi', 'Dumbo Raya', 'Kota Utara', 'Sipatana'
        ];

        // Memulai query dengan eager loading yang dibutuhkan halaman ini
        $query = User::where('role', 'umkm')->with(['kontens', 'kontens.analitik']);

        // Menerapkan logika filter dan pencarian yang sama
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('nib', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('lokasi')) {
            $query->where('lokasi', $request->input('lokasi'));
        }

        if ($request->filled('status_nib')) {
            if ($request->input('status_nib') === 'ber-nib') {
                $query->whereNotNull('nib')->where('nib', '!=', '');
            } elseif ($request->input('status_nib') === 'tidak-ber-nib') {
                $query->where(function ($q) {
                    $q->whereNull('nib')->orWhere('nib', '');
                });
            }
        }

        $umkms = $query->latest()->get();

        return view('laporan.grade', [
            'umkms' => $umkms,
            'lokasiOptions' => $lokasiOptions,
            'selectedLokasi' => $request->input('lokasi'),
            'selectedNibStatus' => $request->input('status_nib'),
            'searchTerm' => $request->input('search'),
        ]);
    }

    /**
     * Menampilkan detail grade konten untuk satu UMKM.
     */
    public function show($umkmId)
    {
        $selectedUmkm = User::where('id', $umkmId)->where('role', 'umkm')->with(['kontens', 'kontens.analitik'])->firstOrFail();
        $kontens = $selectedUmkm->kontens()->with('analitik')->get();
        
        // Ambil daftar UMKM tanpa filter untuk ditampilkan di sidebar
        $umkms = User::where('role', 'umkm')->with(['kontens', 'kontens.analitik'])->latest()->get();
        
        $lokasiOptions = [
            'Kota Tengah', 'Kota Selatan', 'Kota Barat', 'Kota Timur',
            'Hulonthalangi', 'Dungingi', 'Dumbo Raya', 'Kota Utara', 'Sipatana'
        ];

        // Kirim semua variabel yang dibutuhkan oleh view
        return view('laporan.grade', [
            'umkms' => $umkms,
            'kontens' => $kontens,
            'selectedUmkm' => $selectedUmkm,
            'lokasiOptions' => $lokasiOptions,
            'selectedLokasi' => null,
            'selectedNibStatus' => null,
            'searchTerm' => null,
        ]);
    }

    // --- Method lain tidak diubah ---

    public function cetakUmkmPdf()
    {
        $umkms = User::where('role', 'umkm')->get();
        $html = view('laporan.umkm-pdf', compact('umkms'))->render();
        $pdf = PDF::loadHTML($html);
        return $pdf->download('laporan_daftar_umkm_'.date('d_m_Y').'.pdf');
    }

    public function cetakGradePdf()
    {
        $umkms = User::where('role', 'umkm')->with(['kontens', 'kontens.analitik'])->get();
        $html = view('laporan.grade-pdf', compact('umkms'))->render();
        $pdf = PDF::loadHTML($html);
        return $pdf->download('laporan_grade_umkm_'.date('d_m_Y').'.pdf');
    }

    public function cetakGradePdfPerUmkm($umkmId)
    {
        $umkm = User::where('id', $umkmId)->where('role', 'umkm')->with(['kontens', 'kontens.analitik'])->firstOrFail();
        $kontens = $umkm->kontens()->with('analitik')->get();
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