<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [\App\Http\Controllers\ValueController::class, 'index'])->name('index');

Route::post('/value/add', [\App\Http\Controllers\ValueController::class, 'add']);
