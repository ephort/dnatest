<?php

namespace Tests\Unit\Models;

use Tests\TestCase;

class OrderTest extends TestCase
{
    public function test_that_invoice_path_returns_storage_path(): void
    {
        $order = \App\Models\Order::factory()->create();

        $this->assertEquals(
            storage_path('invoices/' . $order->id . '.pdf'),
            $order->invoicePath()
        );
    }

    public function test_verify_returns_false_when_no_order_is_found(): void
    {
        $this->assertFalse(\App\Models\Order::verify('12345678', 'password'));
    }

    public function test_verify_returns_false_when_password_doesnt_match(): void
    {
        $order = \App\Models\Order::factory()->create();

        $this->assertFalse(\App\Models\Order::verify($order->phone, 'password'));
    }

    public function test_verify_returns_true_when_password_matches(): void
    {
        $password = 'pwcleartext';
        $order = \App\Models\Order::factory()->create(['password' => \Hash::make($password)]);

        $this->assertTrue(\App\Models\Order::verify($order->phone, $password));
    }

}
