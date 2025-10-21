<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ValueController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', [ValueController::class, 'index'])->name('index');
Route::post('/value/add', [\App\Http\Controllers\ValueController::class, 'add']);

Route::post('/login', [LoginController::class, 'login'])->name('login.post');
//protected
Route::prefix('quan-ly')->middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout.post');
    Route::prefix('tai-khoan')->middleware(['role:super-admin|admin'])->group(function () {
        Route::get('/test-role', [ValueController::class, 'test'])->name('test');
    });
});

