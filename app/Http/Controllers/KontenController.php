<?php

namespace App\Http\Controllers;

use App\Models\Konten;
use App\Models\Analitik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KontenController extends Controller
{
    /**
     * Menampilkan daftar konten dengan fungsionalitas pencarian.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $searchTerm = $request->input('search');

        $query = $user->kontens()->with('analitik');

        if ($searchTerm) {
            $query->where('judul', 'like', '%' . $searchTerm . '%');
        }

        $kontens = $query->latest()->get();

        return view('konten.index', compact('user', 'kontens', 'searchTerm'));
    }

    public function create()
    {
        $user = auth()->user();
        // Logika ini dipindahkan ke view untuk UX yang lebih baik
        // if (!$user->lokasi || !$user->nib) {
        //     return redirect()->route('umkm.profil')->with('error', 'Silakan lengkapi profil UMKM Anda terlebih dahulu.');
        // }
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
        $konten = Konten::where('user_id', auth()->id())->findOrFail($id);
        return view('konten.show', compact('konten'));
    }
    
    public function edit(Konten $konten)
    {
        if (auth()->id() !== $konten->user_id) {
            abort(403, 'AKSES DITOLAK');
        }
        return view('konten.edit', compact('konten'));
    }

    public function update(Request $request, Konten $konten)
    {
        if (auth()->id() !== $konten->user_id) {
            abort(403, 'AKSES DITOLAK');
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'platform' => 'required|in:instagram,facebook',
            'tanggal_publish' => 'required|date',
        ]);

        if ($request->hasFile('image')) {
            if ($konten->image) {
                Storage::disk('public')->delete($konten->image);
            }
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        $konten->update($validated);

        return redirect()->route('konten.index')->with('success', 'Konten berhasil diperbarui!');
    }

    public function destroy(Konten $konten)
    {
        if (auth()->id() !== $konten->user_id) {
            abort(403, 'AKSES DITOLAK');
        }

        if ($konten->image) {
            Storage::disk('public')->delete($konten->image);
        }
        
        $konten->analitik()->delete();
        $konten->delete();

        return redirect()->route('konten.index')->with('success', 'Konten berhasil dihapus.');
    }

    // Method-method lama yang tidak terpakai bisa dihapus atau diabaikan jika sudah tidak ada rutenya
}

