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
        
        $user = $analitik->konten->user;
        $followers = $user->total_pengikut_instagram ?? 0;
        
        $screenshotPath = $request->file('screenshot')->store('screenshots', 'public');

        // Menghitung Engagement Rate (%) dengan rumus standar
        $engagementRate = $this->calculateRate($request->likes, $request->comments, $request->shares, $followers);
        
        // Menentukan grade berdasarkan persentase ER
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

        return redirect()->route('analitik.index')->with('success', 'Engagement Rate berhasil diperbarui.');
    }

    /**
     * Menghitung Engagement Rate berdasarkan Total Interaksi dan Followers.
     * @return float
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
     * Menentukan grade berdasarkan standar umum Engagement Rate (%).
     * @return string
     */
    public function calculateGrade($engagementRate): string
    {
        // Skala ini umum digunakan untuk ER by Follower/Reach
        if ($engagementRate >= 100) { // Di atas 5% dianggap sangat baik
            return 'A';
        }
        if ($engagementRate >= 50) { // 3.5% - 4.99% dianggap baik
            return 'B';
        }
        if ($engagementRate >= 15) { // 1% - 3.49% dianggap cukup/rata-rata
            return 'C';
        }
        return 'D'; // Di bawah 1% perlu peningkatan
    }
}