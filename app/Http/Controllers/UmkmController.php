<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Konten;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UmkmController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $umkms = [];
        $umkms_per_kecamatan = [];
        $content_counts = [
            'instagram' => 0,
            'facebook' => 0,
        ];
        $content_trends = [
            'instagram' => [],
            'facebook' => [],
            'labels' => [],
        ];

        if ($user->role === 'admin') {
            $umkms = User::where('role', 'umkm')->get();
            // UMKM per kecamatan
            $umkms_per_kecamatan = User::where('role', 'umkm')
                ->groupBy('lokasi')
                ->selectRaw('lokasi, COUNT(*) as jumlah')
                ->pluck('jumlah', 'lokasi')
                ->toArray();
            // Ambil semua konten untuk UMKM
            $umkm_ids = User::where('role', 'umkm')->pluck('id')->toArray();
            // Query konten dengan case-insensitive dan log untuk debug
            $content_counts['instagram'] = Konten::whereRaw('LOWER(platform) = ?', ['instagram'])
                ->whereIn('user_id', $umkm_ids)
                ->count();
            $content_counts['facebook'] = Konten::whereRaw('LOWER(platform) = ?', ['facebook'])
                ->whereIn('user_id', $umkm_ids)
                ->count();
            // Log untuk cek data
            \Log::info('Dashboard Admin Data:', [
                'umkm_ids' => $umkm_ids,
                'instagram_count' => $content_counts['instagram'],
                'facebook_count' => $content_counts['facebook'],
            ]);
        } else {
            $content_counts['instagram'] = $user->kontens()
                ->where('platform', 'instagram')
                ->count();
            $content_counts['facebook'] = $user->kontens()
                ->where('platform', 'facebook')
                ->count();

            $startDate = now()->subMonths(5)->startOfMonth();
            $endDate = now()->endOfMonth();
            $months = collect();
            $currentDate = $startDate->copy();

            while ($currentDate <= $endDate) {
                $months->push($currentDate->format('M Y'));
                $currentDate->addMonth();
            }

            $content_trends['labels'] = $months->toArray();

            $content_trends['instagram'] = $months->map(function ($month) use ($user) {
                $monthDate = \Carbon\Carbon::createFromFormat('M Y', $month);
                return $user->kontens()
                    ->where('platform', 'instagram')
                    ->whereYear('created_at', $monthDate->year)
                    ->whereMonth('created_at', $monthDate->month)
                    ->count();
            })->toArray();

            $content_trends['facebook'] = $months->map(function ($month) use ($user) {
                $monthDate = \Carbon\Carbon::createFromFormat('M Y', $month);
                return $user->kontens()
                    ->where('platform', 'facebook')
                    ->whereYear('created_at', $monthDate->year)
                    ->whereMonth('created_at', $monthDate->month)
                    ->count();
            })->toArray();
        }

        $notifications = $user->unreadNotifications;

        return view('dashboard', compact('user', 'umkms', 'umkms_per_kecamatan', 'content_counts', 'notifications', 'content_trends'));
    }

    // Method lain tidak diubah
    public function report()
    {
        $umkms = User::where('role', 'umkm')->get();
        return view('laporan.umkm', compact('umkms'));
    }

    public function create()
    {
        return view('umkm.create');
    }

    public function store(Request $request)
    {
        \Log::info('UmkmController@store accessed', $request->all());
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'lokasi' => 'required|string|in:Kota Tengah,Kota Selatan,Kota Barat,Kota Timur,Hulonthalangi,Dungingi,Dumbo Raya,Kota Utara,Sipatana',
            'nib' => 'nullable|string|max:13',
            'akun_facebook' => 'nullable|url',
            'akun_instagram' => 'nullable|url',
            'total_pengikut_facebook' => 'nullable|integer|min:0',
            'total_pengikut_instagram' => 'nullable|integer|min:0',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'umkm',
            'nib' => $validated['nib'],
            'lokasi' => $validated['lokasi'],
            'akun_facebook' => $validated['akun_facebook'],
            'akun_instagram' => $validated['akun_instagram'],
            'total_pengikut_facebook' => $validated['total_pengikut_facebook'] ?? 0,
            'total_pengikut_instagram' => $validated['total_pengikut_instagram'] ?? 0,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Registrasi berhasil! Anda telah login.');
    }

    public function profil()
    {
        return view('umkm.profil', ['user' => auth()->user()]);
    }

    public function updateProfil(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
            'lokasi' => 'required|string|in:Kota Tengah,Kota Selatan,Kota Barat,Kota Timur,Hulonthalangi,Dungingi,Dumbo Raya,Kota Utara,Sipatana',
            'nib' => 'nullable|string|max:13',
            'akun_facebook' => 'nullable|url',
            'akun_instagram' => 'nullable|url',
            'total_pengikut_facebook' => 'nullable|integer|min:0',
            'total_pengikut_instagram' => 'nullable|integer|min:0',
            'password' => 'nullable|string|confirmed|min:8',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user();

        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $validated['profile_image'] = $request->file('profile_image')->store('profile_images', 'public');
        } else {
            $validated['profile_image'] = $user->profile_image;
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }
        $user->nib = $validated['nib'];
        $user->lokasi = $validated['lokasi'];
        $user->akun_facebook = $validated['akun_facebook'];
        $user->akun_instagram = $validated['akun_instagram'];
        $user->total_pengikut_facebook = $validated['total_pengikut_facebook'] ?? 0;
        $user->total_pengikut_instagram = $validated['total_pengikut_instagram'] ?? 0;
        $user->profile_image = $validated['profile_image'];
        $user->save();

        return redirect()->route('umkm.profil')->with('success', 'Profil berhasil diperbarui!');
    }

    public function markNotificationAsRead($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        $umkm = User::findOrFail($id);
        if ($umkm->role !== 'umkm') {
            return redirect()->route('laporan.umkm')->with('error', 'Data tersebut bukan UMKM.');
        }
        return view('umkm.edit', compact('umkm'));
    }

    public function update(Request $request, $id)
    {
        $umkm = User::findOrFail($id);
        if ($umkm->role !== 'umkm') {
            return redirect()->route('laporan.umkm')->with('error', 'Data tersebut bukan UMKM.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $umkm->id,
            'lokasi' => 'required|string|in:Kota Tengah,Kota Selatan,Kota Barat,Kota Timur,Hulonthalangi,Dungingi,Dumbo Raya,Kota Utara,Sipatana',
            'nib' => 'nullable|string|max:13',
            'akun_facebook' => 'nullable|url',
            'akun_instagram' => 'nullable|url',
            'total_pengikut_facebook' => 'nullable|integer|min:0',
            'total_pengikut_instagram' => 'nullable|integer|min:0',
            'password' => 'nullable|string|confirmed|min:8',
        ]);

        $umkm->name = $validated['name'];
        $umkm->email = $validated['email'];
        if ($request->filled('password')) {
            $umkm->password = Hash::make($validated['password']);
        }
        $umkm->nib = $validated['nib'];
        $umkm->lokasi = $validated['lokasi'];
        $umkm->akun_facebook = $validated['akun_facebook'];
        $umkm->akun_instagram = $validated['akun_instagram'];
        $umkm->total_pengikut_facebook = $validated['total_pengikut_facebook'] ?? 0;
        $umkm->total_pengikut_instagram = $validated['total_pengikut_instagram'] ?? 0;
        $umkm->save();

        return redirect()->route('laporan.umkm')->with('success', 'Data UMKM berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $umkm = User::findOrFail($id);
        if ($umkm->role !== 'umkm') {
            return redirect()->route('laporan.umkm')->with('error', 'Data tersebut bukan UMKM.');
        }
        $umkm->delete();

        return redirect()->route('laporan.umkm')->with('success', 'Data UMKM berhasil dihapus!');
    }
}