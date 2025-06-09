<?php

namespace App\Http\Controllers;

use App\Models\Analitik;
use App\Models\Konten;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AnalitikController extends Controller
{
    public function index()
    {
        $analitiks = Analitik::with(['konten', 'konten.user'])->get();
        return view('analitik.index', compact('analitiks'));
    }

    public function edit($kontenId)
    {
        $analitik = Analitik::where('konten_id', $kontenId)->firstOrFail();
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
        if (!$request->isMethod('put')) {
            return redirect()->route('analitik.index')->with('error', 'Metode tidak didukung. Gunakan form untuk mengirim data.');
        }

        $analitik = Analitik::where('konten_id', $kontenId)->firstOrFail();
        $konten = $analitik->konten;
        $sevenDaysPassed = $konten->created_at->addDays(7)->lte(now());

        if (!$sevenDaysPassed) {
            return redirect()->back()->with('error', 'Anda hanya dapat mengisi engagement setelah 7 hari pasca-posting.');
        }

        if ($analitik->engagement_filled_at) {
            return redirect()->back()->with('error', 'Engagement untuk konten ini sudah diisi.');
        }

        $request->validate([
            'likes' => 'required|integer|min:0',
            'comments' => 'required|integer|min:0',
            'shares' => 'required|integer|min:0',
            'link' => 'required|url',
            'screenshot' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'link.url' => 'Link harus berupa URL yang valid.',
            'screenshot.required' => 'Screenshot wajib diunggah.',
            'screenshot.image' => 'File harus berupa gambar.',
            'screenshot.mimes' => 'File harus bertipe JPEG, PNG, JPG, atau GIF.',
            'screenshot.max' => 'Ukuran file maksimal 2MB.',
        ]);

        $platform = strtolower($konten->platform);
        $link = $request->link;
        if (($platform === 'facebook' && !str_contains($link, 'facebook.com')) ||
            ($platform === 'instagram' && !str_contains($link, 'instagram.com'))) {
            return redirect()->back()->with('error', 'Link tidak sesuai dengan platform yang dipilih.');
        }

        $user = $konten->user;
        if (!$user) {
            return redirect()->back()->with('error', 'Data pengguna untuk konten ini tidak ditemukan.');
        }

        // Simpan screenshot
        $screenshotPath = null;
        if ($request->hasFile('screenshot')) {
            $screenshotPath = $request->file('screenshot')->store('screenshots', 'public');
        }

        $totalFollowers = ($user->total_pengikut_facebook ?? 0) + ($user->total_pengikut_instagram ?? 0);
        $totalInteraksi = $request->likes + $request->comments + $request->shares;
        $engagementRate = $totalFollowers > 0 ? ($totalInteraksi / $totalFollowers) * 100 : 0;

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

    private function calculateGrade($engagementRate)
    {
        if ($engagementRate >= 70) return 'A';
        if ($engagementRate >= 50) return 'B';
        if ($engagementRate >= 25) return 'C';
        return 'D';
    }
}