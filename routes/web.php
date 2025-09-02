<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\ExaminationController;
use App\Http\Controllers\DiseaseRecordController;
use App\Http\Controllers\HomeController;
use App\Models\Rooms;
use App\Models\Doctor;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
Route::get('/doctor', [HomeController::class, 'doctor'])->name('doctor');

// Doctors
Route::get('doctors', [DoctorController::class, 'index'])->name('doctors.index');
Route::get('doctors/create', function () {
    $rooms = Rooms::all();
    return view('doctors.create', compact('rooms'));
})->name('doctors.create');
Route::post('doctors', [DoctorController::class, 'store'])->name('doctors.store');
Route::get('doctors/{doctor}', [DoctorController::class, 'show'])->name('doctors.show');
Route::get('doctors/{doctor}/edit', function (string $doctor) {
    $rooms = Rooms::all();
    $doctor = Doctor::findOrFail($doctor);
    return view('doctors.edit', compact('rooms', 'doctor'));
})->name('doctors.edit');
Route::put('doctors/{doctor}', [DoctorController::class, 'update'])->name('doctors.update');
Route::delete('doctors/{doctor}', [DoctorController::class, 'destroy'])->name('doctors.destroy');

// Rooms
Route::resource('rooms', RoomController::class);

// Patients
Route::resource('patients', PatientController::class);

// Visits
Route::resource('visits', VisitController::class);

// Examinations
Route::resource('examinations', ExaminationController::class)->except(['create', 'store']);
Route::get('examinations/create/{visit}', [ExaminationController::class, 'create'])->name('examinations.create');
Route::post('examinations/store/{visit}', [ExaminationController::class, 'store'])->name('examinations.store');

// Profile
Route::resource('profile', ProfileController::class);

// Auth
Route::get('login', function () {
    return view('auth.login');
})->name('login');
Route::get('register', function () {
    return view('auth.register');
})->name('register');
Route::post('register', [LoginController::class, 'register'])->name('register.post');
Route::post('login', [LoginController::class, 'login'])->name('login.post');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

// Password reset
Route::get('forget-password', [LoginController::class, 'showResetPasswordForm'])->name('password.request');
Route::post('forget-password', [LoginController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [LoginController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [LoginController::class, 'reset'])->name('password.update');
