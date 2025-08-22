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
        // KODE DIAMBIL DAN DITARUH DI SINI
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
        // ... (kode validasi Anda)

        $analitik = Analitik::where('konten_id', $kontenId)->whereHas('konten', function ($query) {
            $query->where('user_id', auth()->id());
        })->firstOrFail();
        
        // ... (kode validasi lainnya)

        $user = $analitik->konten->user;
        
        $screenshotPath = null;
        if ($request->hasFile('screenshot')) {
            $screenshotPath = $request->file('screenshot')->store('screenshots', 'public');
        }

        $followers = $user->total_pengikut_instagram ?? 0;
        $engagementRate = $this->calculateRate($request->likes, $request->comments, $request->shares, $followers);
        $grade = $this->calculateGrade($engagementRate);

        $analitik->update([
            'likes' => $request->likes,
            'comments' => $request->comments,
            'shares' => $request->shares,
            'engagement_rate' => $engagementRate,
            'grade' => $grade,
            'engagement_filled_at' => now(),
            'screenshot' => $screenshotPath,
        ]);

        return redirect()->route('analitik.index')->with('success', 'Engagement berhasil diperbarui.');
    }

    /**
     * Logika kalkulasi ER dipisahkan ke sini.
     */
    public function calculateRate(int $likes, int $comments, int $shares, int $followers): float
    {
        if ($followers == 0) {
            return 0;
        }
        $totalInteraksi = $likes + $comments + $shares;
        return ($totalInteraksi / $followers) * 100;
    }

    /**
     * Fungsi ini diubah dari 'private' menjadi 'public'.
     */
    public function calculateGrade($engagementRate): string
    {
        if ($engagementRate >= 70) return 'A';
        if ($engagementRate >= 50) return 'B';
        if ($engagementRate >= 25) return 'C';
        return 'D';
    }
}