<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DoctorController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::resource('doctors', DoctorController::class);