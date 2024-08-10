<?php

namespace App\Http\Controllers;

class ExampleController extends Controller
{
    public function shortCircuit(): \Illuminate\Http\JsonResponse
    {
        if (auth()->user() && auth()->user()->isAdmin()) {
            return response()->json(['success' => 'User is admin']);
        }

        return response()->json(['success' => 'User doesnt exist or is not admin']);
    }

    public function sendMail(): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();

        if ($user) {
            \Mail::to($user)->send(new \App\Mail\Welcome($user));
        }

        return response()->json(['success' => 'If user exists, you have received an email']);
    }
}
