<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Konten;
use PHPUnit\Framework\Attributes\Test;

class KontenTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function authenticated_umkm_can_create_new_content(): void
    {
        // Arrange: Buat dan loginkan pengguna UMKM
        $umkmUser = User::factory()->create(['role' => 'umkm']);
        $this->actingAs($umkmUser);

        // Siapkan data konten yang valid dan LENGKAP sesuai aturan validasi
        $kontenData = [
            'judul' => 'Konten Tes Sukses',
            'deskripsi' => 'Ini adalah deskripsi yang valid.',
            'platform' => 'instagram',
            'tanggal_publish' => now()->toDateString(), // Kolom wajib
            'status' => 'draft',                   // Kolom wajib
        ];

        // Act: Kirim request untuk menyimpan konten
        $response = $this->post('/konten', $kontenData);

        // Assert: Pastikan tidak ada error dan data tersimpan
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('kontens', [
            'judul' => 'Konten Tes Sukses'
        ]);
        $response->assertRedirect('/konten');
    }

    #[Test]
    public function content_creation_fails_if_title_is_missing(): void
    {
        // Arrange: Buat dan loginkan pengguna UMKM
        $umkmUser = User::factory()->create(['role' => 'umkm']);
        $this->actingAs($umkmUser);

        // Siapkan data konten yang TIDAK valid (judul kosong)
        $kontenData = [
            'judul' => '', // Dibuat tidak valid
            'deskripsi' => 'Deskripsi tanpa judul.',
            'platform' => 'instagram',
            'tanggal_publish' => now()->toDateString(),
            'status' => 'draft',
        ];

        // Act: Kirim request
        $response = $this->post('/konten', $kontenData);

        // Assert: Pastikan ada error validasi untuk 'judul'
        $response->assertSessionHasErrors('judul');
        $this->assertDatabaseMissing('kontens', [
            'deskripsi' => 'Deskripsi tanpa judul.'
        ]);
    }
}