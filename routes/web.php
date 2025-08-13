<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::resource('doctors', DoctorController::class);

// auth
Route::get('login', function () {
    return view('auth.login');
})->name('login');
Route::get('register', function () {
    return view('auth.register');
})->name('register');

Route::post('register', [LoginController::class, 'register'])->name('register.post');
Route::post('login', [LoginController::class, 'login'])->name('login.post');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

// password reset
Route::get('forget-password', [LoginController::class, 'showResetPasswordForm'])->name('password.request');
Route::post('forget-password', [LoginController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [LoginController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [LoginController::class, 'reset'])->name('password.update');

// profile
Route::get('profile', function () {
    return view('profile.create');
})->name('profile');

Route::get('profile/index', [ProfileController::class, 'index'])->name('profile.index');
Route::put('profile/update', [ProfileController::class, 'update'])->name('profile.update');