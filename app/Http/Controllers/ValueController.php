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
        $data = User::all();
        return Inertia::render('Index', ['data' => $data]);
    }

    public function add(Request $request)
    {
        User::create([
            'email' => $request->input('email'),
            'password' => Hash::make($request->input(['password']))
        ]);
        return redirect()->route('index');
    }
}
