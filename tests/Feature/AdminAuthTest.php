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
            'is_admin' => true,
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

    public function test_non_admin_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->create([
            'is_admin' => false,
        ]);

        $this->actingAs($user)
            ->get('/dashboard/admin')
            ->assertForbidden();
    }
}
