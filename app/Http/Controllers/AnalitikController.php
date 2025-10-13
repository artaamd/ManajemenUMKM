<?php

namespace App\Http\Controllers;

use App\Models\Analitik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnalitikController extends Controller
{
    /**
     * Menampilkan halaman utama analitik dengan fungsionalitas pencarian.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $searchTerm = $request->input('search');

        // Cek hanya untuk user dengan role 'umkm'
        if ($user->role === 'umkm') {
            $profileUpdatedAt = $user->profile_updated_at;
            
            if (!$profileUpdatedAt || now()->subDays(7)->gt($profileUpdatedAt)) {
                return redirect()->route('umkm.profil')
                    ->with('warning', 'Untuk mengakses fitur Penilaian Tingkat Interaksi, Anda wajib memperbarui profil Anda setiap 7 hari sekali. Silakan perbarui data Anda.');
            }
        }

        // Mulai query untuk mengambil data analitik
        $query = Analitik::whereHas('konten', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        });

        // Terapkan filter pencarian jika ada
        if ($searchTerm) {
            $query->whereHas('konten', function ($q) use ($searchTerm) {
                $q->where('judul', 'like', '%' . $searchTerm . '%');
            });
        }

        $analitiks = $query->with(['konten' => function ($query) {
            $query->orderBy('tanggal_publish', 'desc');
        }])->get();

        return view('analitik.index', compact('analitiks', 'searchTerm'));
    }

    // --- Method lain tidak diubah ---

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

    public function update(Request $request, $kontenId)
    {
        $request->validate([
            'likes' => 'required|integer|min:0',
            'comments' => 'required|integer|min:0',
            'shares' => 'required|integer|min:0',
            'link_postingan' => 'required|url',
            'screenshot' => 'required|image|max:2048',
        ]);

        $analitik = Analitik::where('konten_id', $kontenId)->whereHas('konten', function ($query) {
            $query->where('user_id', auth()->id());
        })->firstOrFail();
        
        $user = $analitik->konten->user;
        $followers = $user->total_pengikut_instagram ?? 0;
        
        $screenshotPath = $request->file('screenshot')->store('screenshots', 'public');

        $engagementRate = $this->calculateRate($request->likes, $request->comments, $request->shares, $followers);
        
        $grade = $this->calculateGrade($engagementRate);

        $analitik->update([
            'likes' => $request->likes,
            'comments' => $request->comments,
            'shares' => $request->shares,
            'link_postingan' => $request->link_postingan,
            'engagement_rate' => $engagementRate,
            'grade' => $grade,
            'engagement_filled_at' => now(),
            'screenshot' => $screenshotPath,
        ]);

        return redirect()->route('analitik.index')->with('success', 'Engagement Rate berhasil diperbarui.');
    }

    public function calculateRate(int $likes, int $comments, int $shares, int $followers): float
    {
        if ($followers == 0) {
            return 0;
        }
        
        $totalInteraksi = $likes + $comments + $shares;

        return ($totalInteraksi / $followers) * 100;
    }
    
    public function calculateGrade($engagementRate): string
    {
        if ($engagementRate >= 100) { 
            return 'A';
        }
        if ($engagementRate >= 50) {
            return 'B';
        }
        if ($engagementRate >= 15) {
            return 'C';
        }
        return 'D';
    }
}

