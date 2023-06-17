<?php

namespace Tests\Feature;

use Tests\TestCase;

class OrderTest extends TestCase
{
    public function test_that_a_dnatest_can_be_ordered(): void
    {
        $response = $this->post('/orders', [
            'name' => 'John Doe',
            'address' => 'Test Street 1',
            'phone' => '12345678',
            'password' => 'qwerty',
        ]);

        $response->assertSessionHas('success');
        $response->isRedirect('/');
    }

    public function test_that_order_requires_name(): void
    {
        $response = $this->post('/orders', [
            'address' => 'Test Street 1',
            'phone' => '12345678',
        ]);

        $response->isRedirect('/');
        $response->assertSessionHas('error');
    }

    public function test_that_order_requires_address(): void
    {
        $response = $this->post('/orders', [
            'name' => 'John Doe',
            'phone' => '12345678',
        ]);

        $response->isRedirect('/');
        $response->assertSessionHas('error');
    }

    public function test_that_order_requires_phone(): void
    {
        $response = $this->post('/orders', [
            'name' => 'John Doe',
            'address' => 'Test Street 1',
        ]);

        $response->isRedirect('/');
        $response->assertSessionHas('error');
    }

    public function test_that_order_requires_password(): void
    {
        $response = $this->post('/orders', [
            'name' => 'John Doe',
            'address' => 'Test Street 1',
            'phone' => '12345678',
        ]);

        $response->isRedirect('/');
        $response->assertSessionHas('error');
    }

    public function test_that_a_order_shows_pdf(): void
    {
        $order = \App\Models\Order::factory()->create();

        $response = $this->get('/orders/' . $order->id);

        $this->assertEquals('application/pdf', $response->headers->get('content-type'));
    }
}
