<?php

namespace Tests\Unit\Jobs;

use Tests\TestCase;

class GenerateInvoiceTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_must_receive_order(): void
    {
        $this->expectException(\ArgumentCountError::class);

        new \App\Jobs\GenerateInvoice();
    }

    public function test_returns_path_to_invoice(): void
    {
        $order = \App\Models\Order::factory()->create();

        $invoice = new \App\Jobs\GenerateInvoice($order);

        $this->assertEquals(
            storage_path('invoices/' . $order->id . '.pdf'),
            $invoice->handle()
        );
    }

    public function test_generates_file_with_pdf_mimetype(): void
    {
        $order = \App\Models\Order::factory()->create();

        $invoice = new \App\Jobs\GenerateInvoice($order);

        $invoice->handle();

        $this->assertEquals(
            'application/pdf',
            mime_content_type($order->invoicePath())
        );
    }
}
