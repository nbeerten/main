<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class PagesTest extends TestCase
{
    /**
     * Homepage test.
     */
    public function test_the_homepage_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Contact test.
     */
    public function test_the_contact_page_returns_a_successful_response(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
    }

    /**
     * Dashboard test.
     */
    public function test_the_dashboard_page_returns_a_successful_response(): void
    {
        /**
         * @var \Illuminate\Contracts\Auth\Authenticatable $user
         */
        $user = User::where('id', '=', 1)->exists() ? Auth::loginUsingId(1) : User::factory()->create();

        $response = $this->actingAs($user)
                         ->get('/dashboard');

        $response->assertStatus(200);
    }

    /**
     * 404 page test.
     */
    public function test_the_404_page_returns_a_404_page_not_found_response(): void
    {
        $response = $this->get('/'.fake()->slug());

        $response->assertStatus(404);
    }
}
