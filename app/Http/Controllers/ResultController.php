<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Validation\ValidationException;

class ResultController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        return view('result');
    }

    public function store(): \Illuminate\Http\JsonResponse
    {
        try {
            $data = $this->validate(request(), [
                'phone' => 'required',
                'password' => 'required',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Please fill out all fields!']);
        }

        if (! Order::verify($data['phone'], $data['password'])) {
            return response()->json(['error' => 'Phone or password incorrect!']);
        }

        return response()->json(['success' => 'Your test was positive!']);
    }
}
