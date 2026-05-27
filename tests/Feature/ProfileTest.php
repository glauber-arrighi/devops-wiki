<?php
namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user)->get('/profile')->assertOk();
    }

    public function test_profile_page_has_user_data(): void
    {
        $user = User::factory()->create(['name' => 'Test User']);
        $response = $this->actingAs($user)->get('/profile');
        $response->assertOk()->assertSee('Test User');
    }
}
