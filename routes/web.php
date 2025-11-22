<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\WebBookingController;
use App\Http\Controllers\PaymentWebController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes (Frontend Blade)
|--------------------------------------------------------------------------
*/

// Landing page
Route::get('/', [HomeController::class, 'index'])->name('home');

// ----------------------------
// Auth Pages (LOGIN & REGISTER)
// ----------------------------
Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');

// ----------------------------
// CUSTOMER PAGES
// ----------------------------

// List travel → detail
Route::get('/travel/{id}', [WebBookingController::class, 'detail'])->name('travel.detail');

// History booking
Route::middleware('auth')->get('/bookings', [WebBookingController::class, 'history'])->name('bookings');

// Detail booking
Route::middleware('auth')->get('/bookings/{id}', [WebBookingController::class, 'show'])->name('booking.show');

// Upload bukti pembayaran
Route::middleware('auth')->get('/payment/upload/{id}', [PaymentWebController::class, 'uploadForm'])->name('payment.upload');

// Invoice HTML
Route::middleware('auth')->get('/invoice/{id}', [PaymentWebController::class, 'invoice'])->name('invoice');

// ----------------------------
// ADMIN PAGES
// ----------------------------
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/travels', [AdminController::class, 'travels'])->name('admin.travels');
    Route::get('/admin/payments', [AdminController::class, 'payments'])->name('admin.payments');

    Route::get('/admin/reports/travels', function () {
        return view('admin.report_travels');
    })->name('admin.report.travels');
});
