<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\dashboardcontroller;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/dashboard');

Route::middleware(['auth', 'role:admin'])->prefix('dashboard')->group(function () {
    Route::view('/', 'lgs.temp')->name('home');
    Route::resource('/products', ProductController::class);
    Route::resource('/users',UserController::class);
    Route::put('/users/{user}/toggle', [UserController::class, 'toggleRole'])->name('user.toggle');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('guest')->group(function() {
    Route::view('/login', 'lgs.auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});
