<?php

namespace App\Http\Controllers;

use App\Models\Analitik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnalitikController extends Controller
{
    /**
     * Menampilkan halaman utama analitik.
     */
    public function index()
    {
        $analitiks = Analitik::whereHas('konten', function ($query) {
            $query->where('user_id', auth()->id());
        })->with(['konten' => function ($query) {
            $query->orderBy('tanggal_publish', 'desc');
        }])->get();

        return view('analitik.index', compact('analitiks'));
    }

    /**
     * Menampilkan form untuk mengisi data engagement.
     */
    public function edit($kontenId)
    {
        $analitik = Analitik::where('konten_id', $kontenId)
            ->whereHas('konten', function ($query) {
                $query->where('user_id', auth()->id());
            })->firstOrFail();
            
        $konten = $analitik->konten;
        $sevenDaysPassed = $konten->created_at->addDays(7)->lte(now());

        if (!$sevenDaysPassed) {
            return redirect()->back()->with('error', 'Anda hanya dapat mengisi engagement setelah 7 hari pasca-posting.');
        }

        if ($analitik->engagement_filled_at) {
            return redirect()->back()->with('error', 'Engagement untuk konten ini sudah diisi.');
        }

        return view('analitik.edit', compact('analitik', 'sevenDaysPassed'));
    }

    /**
     * Memperbarui data engagement.
     */
    public function update(Request $request, $kontenId)
    {
        $request->validate([
            'likes' => 'required|integer|min:0',
            'comments' => 'required|integer|min:0',
            'shares' => 'required|integer|min:0',
            'screenshot' => 'required|image|max:2048',
        ]);

        $analitik = Analitik::where('konten_id', $kontenId)->whereHas('konten', function ($query) {
            $query->where('user_id', auth()->id());
        })->firstOrFail();
        
        $screenshotPath = $request->file('screenshot')->store('screenshots', 'public');

        // Menghitung skor engagement berdasarkan total interaksi
        $engagementScore = $this->calculateScore($request->likes, $request->comments, $request->shares);
        
        // Menentukan grade berdasarkan skor
        $grade = $this->calculateGrade($engagementScore);

        $analitik->update([
            'likes' => $request->likes,
            'comments' => $request->comments,
            'shares' => $request->shares,
            'engagement_rate' => $engagementScore, // Kolom 'engagement_rate' diisi dengan skor total
            'grade' => $grade,
            'engagement_filled_at' => now(),
            'screenshot' => $screenshotPath,
        ]);

        return redirect()->route('analitik.index')->with('success', 'Skor engagement berhasil diperbarui.');
    }

    /**
     * Menghitung SKOR TOTAL INTERAKSI.
     * @return int
     */
    public function calculateScore(int $likes, int $comments, int $shares): int
    {
        return $likes + $comments + $shares;
    }

    /**
     * Menentukan grade berdasarkan total skor interaksi.
     * Angka-angka ini adalah contoh dan dapat Anda sesuaikan.
     * @return string
     */
    public function calculateGrade($engagementScore): string
    {
        if ($engagementScore >= 1000) {
            return 'A'; // Sangat Baik
        }
        if ($engagementScore >= 500) {
            return 'B'; // Baik
        }
        if ($engagementScore >= 100) {
            return 'C'; // Cukup
        }
        return 'D'; // Perlu Peningkatan
    }
}