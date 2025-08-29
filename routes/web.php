<?php

use App\Http\Controllers\UmkmController;
use App\Http\Controllers\KontenController;
use App\Http\Controllers\AnalitikController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Auth\AdminAuthController;
use Illuminate\Support\Facades\Route;

// Pastikan routes/auth.php dimuat
require __DIR__.'/auth.php';

Route::get('/', [LandingController::class, 'index'])->name('landing');

// Redirect GET /umkm ke /umkm/create
Route::get('/umkm', function () {
    return redirect()->route('umkm.create');
});

// Route untuk registrasi UMKM (diakses oleh tamu)
Route::get('/umkm/create', [UmkmController::class, 'create'])->name('umkm.create')->middleware('guest');
Route::post('/umkm', [UmkmController::class, 'store'])->name('umkm.store')->middleware('guest');

// Route yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [UmkmController::class, 'index'])->name('dashboard');
    Route::get('/konten', [KontenController::class, 'index'])->name('konten.index');
    Route::get('/analitik', [AnalitikController::class, 'index'])->name('analitik.index');
    Route::get('/konten/create', [KontenController::class, 'create'])->name('konten.create');
    Route::post('/konten', [KontenController::class, 'store'])->name('konten.store');
    Route::get('/konten/preview', [KontenController::class, 'preview'])->name('konten.preview')->middleware('role:umkm');
    Route::get('/konten/{id}', [KontenController::class, 'show'])->name('konten.show');
    Route::post('/konten/{id}/mark-uploaded', [KontenController::class, 'markUploaded'])->name('konten.markUploaded');
    Route::get('/laporan/umkm', [LaporanController::class, 'umkm'])->name('laporan.umkm')->middleware('role:admin');
    Route::get('/laporan/grade', [LaporanController::class, 'grade'])->name('laporan.grade')->middleware('role:admin');
    Route::get('/laporan/grade/{umkmId}', [LaporanController::class, 'show'])->name('laporan.grade.show')->middleware('role:admin');
    Route::get('/laporan/umkm/cetak-pdf', [LaporanController::class, 'cetakUmkmPdf'])->name('laporan.umkm.cetak-pdf')->middleware('role:admin');
    Route::get('/laporan/grade/cetak-pdf', [LaporanController::class, 'cetakGradePdf'])->name('laporan.grade.cetak-pdf')->middleware('role:admin');
    Route::get('/umkm/profil', [UmkmController::class, 'profil'])->name('umkm.profil')->middleware('role:umkm');
    Route::put('/umkm/profil', [UmkmController::class, 'updateProfil'])->name('umkm.updateProfil')->middleware('role:umkm');
    Route::post('/mark-notification-as-read/{id}', [UmkmController::class, 'markNotificationAsRead'])->name('mark.notification.read');
    Route::get('/laporan/grade/{umkmId}/cetak-pdf', [LaporanController::class, 'cetakGradePdfPerUmkm'])->name('laporan.grade.cetak-per-umkm')->middleware('role:admin');
    Route::get('/laporan/grade/{umkmId}/cetak-excel', [LaporanController::class, 'cetakExcelPerUmkm'])->name('laporan.grade.cetak-excel-per-umkm')->middleware('role:admin');
    Route::get('/laporan/umkm/cetak-excel', [LaporanController::class, 'cetakUmkmExcel'])->name('laporan.umkm.cetak-excel')->middleware('role:admin');
    Route::get('/konten/{id}/edit-engagement', [KontenController::class, 'editEngagement'])->name('konten.editEngagement')->middleware('role:umkm');
    Route::post('/konten/{id}/update-engagement', [KontenController::class, 'updateEngagement'])->name('konten.updateEngagement')->middleware('role:umkm');
    Route::get('/konten/{konten}/edit', [KontenController::class, 'edit'])->name('konten.edit')->middleware('role:umkm');
    Route::put('/konten/{konten}', [KontenController::class, 'update'])->name('konten.update')->middleware('role:umkm');
    Route::delete('/konten/{konten}', [KontenController::class, 'destroy'])->name('konten.destroy')->middleware('role:umkm');
    Route::get('/admin/users/create', [UmkmController::class, 'createByAdmin'])->name('admin.users.create')->middleware('role:admin');
    Route::post('/admin/users', [UmkmController::class, 'storeByAdmin'])->name('admin.users.store')->middleware('role:admin');

    // Tambahkan route untuk edit dan hapus UMKM (hanya untuk admin)
    Route::get('/umkm/{id}/edit', [UmkmController::class, 'edit'])->name('umkm.edit')->middleware('role:admin');
    Route::put('/umkm/{id}', [UmkmController::class, 'update'])->name('umkm.update')->middleware('role:admin');
    Route::delete('/umkm/{id}', [UmkmController::class, 'destroy'])->name('umkm.destroy')->middleware('role:admin');

    // Tambahkan rute untuk engagement di halaman analitik
    Route::get('/analitik/{kontenId}/edit', [AnalitikController::class, 'edit'])->name('analitik.edit');
    Route::put('/analitik/{kontenId}', [AnalitikController::class, 'update'])->name('analitik.update');
    Route::get('/analitik/{kontenId}', function ($kontenId) {
        return redirect()->route('analitik.edit', $kontenId);
    });
});

Route::get('/register', function () {
    return redirect()->route('login');
});

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login')->middleware('guest');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});