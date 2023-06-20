<?php

namespace Tests\Feature;

use Tests\TestCase;

class ResultTest extends TestCase
{
    public function test_that_the_result_page_contains_phone_number_and_password_form_fields(): void
    {
        $response = $this->get('/results');

        $response->assertSee('name="phone"', false);
        $response->assertSee('name="password"', false);
    }

    public function test_that_phone_is_required(): void
    {
        $response = $this->post('/api/results', [
            'password' => '12345678',
        ]);

        $response->assertJsonStructure(['error']);
    }

    public function test_that_password_is_required(): void
    {
        $response = $this->post('/api/results', [
            'phone' => '12345678',
        ]);

        $response->assertJsonStructure(['error']);
    }

    public function test_that_a_result_can_be_viewed(): void
    {
        $password = 'pwcleartext';
        $order = \App\Models\Order::factory()->create(['password' => \Hash::make($password)]);

        $response = $this->post('/api/results', [
            'phone' => $order->phone,
            'password' => $password,
        ]);

        $response->assertExactJson(['success' => 'Your test was positive!']);
    }
}
