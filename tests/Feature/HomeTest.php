<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_frontpage_contains_order_now_button(): void
    {
        $response = $this->get('/');

        $response->assertSee('Order now');
    }

    public function test_frontpage_contains_test_result_button(): void
    {
        $response = $this->get('/');

        $response->assertSee('data-testid="test-result"', false);
    }
}
