<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientProfileController;
use App\Http\Controllers\RiskFactorController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);


    Route::get('/identitas-diri', [PatientProfileController::class, 'create'])->name('identitas-diri.create');
    Route::post('/identitas-diri', [PatientProfileController::class, 'store'])->name('identitas-diri.store');
    Route::get('/faktor-risiko/{user_id}', [RiskFactorController::class, 'create'])->name('faktor-risiko.create');
    Route::post('/faktor-risiko/{user_id}', [RiskFactorController::class, 'store'])->name('faktor-risiko.store');

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::get('/', function () {
    return view('welcome');
});
