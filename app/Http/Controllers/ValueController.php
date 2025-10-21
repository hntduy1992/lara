<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class ValueController extends Controller
{
    public function index()
    {
        return Inertia::render('Index', []);
    }

    public function add(Request $request)
    {
        User::create([
            'email' => $request->input('email'),
            'password' => Hash::make($request->input(['password']))
        ]);
        return redirect()->route('index');
    }

    public function test(Request $request)
    {
        return response()->json(['data' => 'This ok']);
    }
}
