<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ValueController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/login', [LoginController::class, 'getLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
//protected
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Index', []);
    });
    Route::delete('/logout', [LoginController::class, 'destroy'])->name('logout.post');
    Route::prefix('/department')->middleware(['role:super-admin|admin'])->group(function () {
//        Route::get('/list')
    });
});


//Error page
Route::get('/error-unauthenticated', function () {
    return Inertia::render('Error', ['message' => 'Bạn không có quyền truy cập nội dung này']);
});
