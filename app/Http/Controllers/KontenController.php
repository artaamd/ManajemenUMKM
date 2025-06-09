<?php

namespace App\Http\Controllers;

use App\Models\Konten;
use App\Models\Analitik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KontenController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $kontens = $user->kontens()->with('analitik')->get(); // Eager load analitik
        return view('konten.index', compact('user', 'kontens'));
    }

    public function create()
    {
        $user = auth()->user();
        if (!$user->lokasi && !$user->nib) {
            return redirect()->route('umkm.profil')->with('error', 'Silakan lengkapi profil UMKM Anda terlebih dahulu.');
        }
        return view('konten.create', compact('user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'platform' => 'required|in:instagram,facebook',
            'tanggal_publish' => 'required|date',
            'status' => 'required|in:draft,published,scheduled',
        ]);

        $user = auth()->user();

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        $konten = Konten::create([
            'user_id' => $user->id,
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'image' => $imagePath,
            'platform' => $validated['platform'],
            'tanggal_publish' => $validated['tanggal_publish'],
            'status' => $validated['status'],
        ]);

        // Buat entri Analitik secara otomatis
        Analitik::create([
            'konten_id' => $konten->id,
            'platform' => $konten->platform,
        ]);

        return redirect()->route('konten.index')->with('success', 'Konten berhasil ditambahkan!');
    }

    public function preview()
    {
        $user = auth()->user();
        $kontens = $user->kontens;
        return view('konten.preview', compact('user', 'kontens'));
    }

    public function show($id)
    {
        $konten = Konten::findOrFail($id);
        return view('konten.show', compact('konten'));
    }

    public function markUploaded(Request $request, $id)
    {
        $konten = Konten::findOrFail($id);
        $konten->update(['status' => 'published']);

        $user = auth()->user();
        $user->unreadNotifications()
            ->where('data->konten_id', $id)
            ->update(['read_at' => now()]);

        return redirect()->route('konten.index')->with('success', 'Konten telah ditandai sebagai dipublikasikan.');
    }

    public function editEngagement($id)
    {
        $konten = Konten::where('user_id', auth()->user()->id)->with('analitik')->findOrFail($id);
        $analitik = $konten->analitik ?: new Analitik(['konten_id' => $konten->id]);
        $sevenDaysPassed = $konten->created_at->addDays(7)->lte(now());

        if (!$sevenDaysPassed) {
            return redirect()->route('konten.index')->with('error', 'Anda hanya dapat mengisi engagement setelah 7 hari pasca-posting.');
        }

        if ($analitik->engagement_filled_at) {
            return redirect()->route('konten.index')->with('error', 'Engagement untuk konten ini sudah diisi.');
        }

        return view('konten.edit-engagement', compact('konten', 'analitik', 'sevenDaysPassed'));
    }

    public function updateEngagement(Request $request, $id)
    {
        $konten = Konten::where('user_id', auth()->user()->id)->with('analitik')->findOrFail($id);
        $analitik = $konten->analitik ?: new Analitik(['konten_id' => $konten->id]);
        $sevenDaysPassed = $konten->created_at->addDays(7)->lte(now());

        if (!$sevenDaysPassed) {
            return redirect()->route('konten.index')->with('error', 'Anda hanya dapat mengisi engagement setelah 7 hari pasca-posting.');
        }

        if ($analitik->engagement_filled_at) {
            return redirect()->route('konten.index')->with('error', 'Engagement untuk konten ini sudah diisi.');
        }

        $request->validate([
            'likes' => 'required|integer|min:0',
            'comments' => 'required|integer|min:0',
            'shares' => 'required|integer|min:0',
            'link' => 'required|url',
            'screenshot' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'link.url' => 'Link harus berupa URL yang valid.',
        ]);

        $platform = strtolower($konten->platform);
        $link = $request->link;
        if (($platform === 'facebook' && !str_contains($link, 'facebook.com')) ||
            ($platform === 'instagram' && !str_contains($link, 'instagram.com'))) {
            return redirect()->route('konten.index')->with('error', 'Link tidak sesuai dengan platform yang dipilih.');
        }

        $user = $konten->user;
        if (!$user) {
            return redirect()->route('konten.index')->with('error', 'Data pengguna untuk konten ini tidak ditemukan.');
        }

        $totalFollowers = ($user->total_pengikut_facebook ?? 0) + ($user->total_pengikut_instagram ?? 0);
        $totalInteraksi = $request->likes + $request->comments + $request->shares;
        $engagementRate = $totalFollowers > 0 ? ($totalInteraksi / $totalFollowers) * 100 : 0;

        $grade = $this->calculateGrade($engagementRate);

        $analitik->fill([
            'konten_id' => $konten->id,
            'platform' => $konten->platform,
            'likes' => $request->likes,
            'comments' => $request->comments,
            'shares' => $request->shares,
            'engagement_rate' => $engagementRate,
            'grade' => $grade,
            'engagement_filled_at' => now(),
        ]);

        if ($request->hasFile('screenshot')) {
            if ($analitik->screenshot) {
                Storage::disk('public')->delete($analitik->screenshot);
            }
            $analitik->screenshot = $request->file('screenshot')->store('screenshots', 'public');
        }

        $analitik->save();

        return redirect()->route('konten.index')->with('success', 'Engagement berhasil diperbarui.');
    }

    private function calculateGrade($engagementRate)
    {
        if ($engagementRate >= 70) return 'A';
        if ($engagementRate >= 50) return 'B';
        if ($engagementRate >= 25) return 'C';
        return 'D';
    }
}