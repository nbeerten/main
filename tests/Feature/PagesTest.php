<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Str;

class PagesTest extends TestCase
{
    /**
     * Homepage test.
     *
     * @return void
     */
    public function test_the_homepage_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    
    /**
     * Contact test.
     *
     * @return void
     */
    public function test_the_contact_page_returns_a_successful_response()
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
    }
    
    /**
     * Dashboard test.
     *
     * @return void
     */
    public function test_the_dashboard_page_returns_a_successful_response()
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
     *
     * @return void
     */
    public function test_the_404_page_returns_a_404_page_not_found_response()
    {
        $response = $this->get('/' . fake()->slug());

        $response->assertStatus(404);
    }
}
