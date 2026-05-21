<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_login_and_access_dashboard(): void
    {
        $admin = User::factory()->create([
            'nama' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => 'admin123',
        ]);

        $this->post('/login', [
            'email' => $admin->email,
            'password' => 'admin123',
        ])
            ->assertRedirect('/dashboard/admin');

        $this->actingAs($admin)
            ->get('/dashboard/admin')
            ->assertOk();
    }
}
