<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SSOController;

Route::get('/login', [SSOController::class, 'login'])->name('login');
Route::get('/logout', [SSOController::class, 'logout']);
Route::get('/dashboard', [SSOController::class, 'dashboard'])->middleware('auth.sso');

Route::get('/', function () {
    return view('welcome');
});
// Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('verify.sso');
// Route::get('/dashboard', [SSOController::class, 'dashboard'])->middleware('auth.sso');
