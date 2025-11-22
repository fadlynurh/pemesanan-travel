<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Route untuk halaman Blade (Frontend)
|--------------------------------------------------------------------------
*/

// Halaman Welcome (opsional)
Route::get('/', function(){
    return view('welcome');
});

// ----------------------------
// Auth Pages (LOGIN & REGISTER)
// ----------------------------
Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');

// ----------------------------
// Customer Pages
// ----------------------------
Route::view('/dashboard', 'customer.dashboard')->name('dashboard');

// ----------------------------
// Admin Pages
// ----------------------------
Route::view('/admin', 'admin.index')->name('admin.index');
Route::view('/admin/travels', 'admin.travels')->name('admin.travels');
