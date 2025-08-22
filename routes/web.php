<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\PatientController;
use App\Models\patients;
use App\Models\rooms;
use App\Models\doctor;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// doctors
Route::get('doctors', [DoctorController::class, 'index'])->name('doctors.index');
Route::get('doctors/create', function () {
    $rooms = rooms::all();
    return view('doctors.create', compact('rooms'));
})->name('doctors.create');
Route::post('doctors', [DoctorController::class, 'store'])->name('doctors.store');
Route::get('doctors/{doctor}', [DoctorController::class, 'show'])->name('doctors.show');
// Route::get('doctors/{doctor}/edit', [DoctorController::class, 'edit'])->name('doctors.edit');

Route::get('doctors/{doctor}/edit', function (string $doctor) {
    $rooms = rooms::all();
    $doctor = Doctor::findOrFail($doctor);
    return view('doctors.edit', compact('rooms', 'doctor'));
})->name('doctors.edit');

Route::put('doctors/{doctor}', [DoctorController::class, 'update'])->name('doctors.update');
Route::delete('doctors/{doctor}', [DoctorController::class, 'destroy'])->name('doctors.destroy');

// rooms
Route::resource('rooms', RoomController::class);

// patients
Route::resource('patients', PatientController::class);
Route::patch('/patients/{patient}/status', [PatientController::class, 'updateStatus'])->name('patients.updateStatus');

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
