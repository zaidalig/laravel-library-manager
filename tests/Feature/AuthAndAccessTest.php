<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthAndAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get('/')->assertRedirect('/login');
    }

    public function test_owner_can_view_dashboard(): void
    {
        $user = User::create([
            'name' => 'Owner',
            'email' => 'owner@test.local',
            'password' => 'password',
            'role' => 'owner',
            'status' => 'active',
        ]);

        $this->actingAs($user)->get('/')->assertOk();
    }

    public function test_owner_can_access_all_modules(): void
    {
        $user = User::create([
            'name' => 'Owner',
            'email' => 'owner-all@test.local',
            'password' => 'password',
            'role' => 'owner',
            'status' => 'active',
        ]);

        $this->actingAs($user)->get('/books')->assertOk();
        $this->actingAs($user)->get('/loans')->assertOk();
        $this->actingAs($user)->get('/users')->assertOk();
    }

    public function test_librarian_can_manage_library_but_not_users(): void
    {
        $user = User::create([
            'name' => 'Librarian',
            'email' => 'librarian@test.local',
            'password' => 'password',
            'role' => 'librarian',
            'status' => 'active',
        ]);

        $this->actingAs($user)->get('/books')->assertOk();
        $this->actingAs($user)->get('/loans')->assertOk();
        $this->actingAs($user)->get('/users')->assertForbidden();
    }

    public function test_viewer_cannot_manage_library(): void
    {
        $user = User::create([
            'name' => 'Viewer',
            'email' => 'viewer@test.local',
            'password' => 'password',
            'role' => 'viewer',
            'status' => 'active',
        ]);

        $this->actingAs($user)->get('/books')->assertForbidden();
    }
}
