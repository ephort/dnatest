<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateInvoice;

class OrderController extends Controller
{
    public function store(): \Illuminate\Http\RedirectResponse
    {
        try {
            $data = $this->validate(request(), [
                'name' => 'required',
                'address' => 'required',
                'phone' => 'required',
                'password' => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect('/')->with('error', 'Please fill out all fields!');
        }

        $data['password'] = \Hash::make($data['password']);

        $order = \App\Models\Order::create($data);

        return redirect('/')->with(
            'success',
            'Your order has been received 🙏 Your invoice is available at <a href="/orders/' . $order->id . '"><u>this page</u></a>.',
        );
    }

    public function show(\App\Models\Order $order)
    {
        if (! file_exists($order->invoicePath())) {
            dispatch_sync(new GenerateInvoice($order));
        }

        return response()->file($order->invoicePath());
    }
}
