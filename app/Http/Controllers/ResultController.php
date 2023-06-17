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

    public function store(): \Illuminate\Http\RedirectResponse|\Illuminate\View\View
    {
        try {
            $data = $this->validate(request(), [
                'phone' => 'required',
                'password' => 'required',
            ]);
        } catch (ValidationException $e) {
            return redirect('/results')->with('error', 'Please fill out all fields!');
        }

        if (! Order::verify($data['phone'], $data['password'])) {
            return redirect('/results')->with('error', 'Phone or password incorrect!');
        }

        session()->flash('success', 'Your test was positive!');

        return view('result');
    }
}
