<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SSOController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', [SSOController::class, 'showLoginForm'])->name('login');
Route::post('/login', [SSOController::class, 'login']);
Route::get('/logout', [SSOController::class, 'logout']);
Route::get('/dashboard', [SSOController::class, 'dashboard'])->middleware('auth.sso');