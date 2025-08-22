<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test; // Tambahkan ini

class AuthTest extends TestCase
{
    use RefreshDatabase;

    #[Test] 
    public function umkm_can_login_with_valid_credentials(): void 
    {
        
        $user = User::factory()->create([
            'email' => 'umkm.sukses@test.com',
            'password' => bcrypt('password123'),
            'role' => 'umkm'
        ]);
        $response = $this->post('/login', [
            'email' => 'umkm.sukses@test.com',
            'password' => 'password123'
        ]);
        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    #[Test] 
    public function umkm_cannot_login_with_invalid_credentials(): void 
    {
       
        $user = User::factory()->create([
            'email' => 'umkm.gagal@test.com',
            'password' => bcrypt('password123')
        ]);
        $response = $this->post('/login', [
            'email' => 'umkm.gagal@test.com',
            'password' => 'password-salah'
        ]);
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}