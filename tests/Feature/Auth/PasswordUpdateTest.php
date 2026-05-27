<?php
namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasswordUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_update_screen_exists(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user)->get('/profile')->assertStatus(200);
    }
}
