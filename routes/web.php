<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\BreastExamController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RiskFactorController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);


    Route::get('/identitas-diri', [PatientProfileController::class, 'create'])->name('identitas-diri.create');
    Route::post('/identitas-diri', [PatientProfileController::class, 'store'])->name('identitas-diri.store');
    Route::get('/faktor-risiko', [RiskFactorController::class, 'create'])->name('faktor-risiko.create');
    Route::post('/faktor-risiko', [RiskFactorController::class, 'store'])->name('faktor-risiko.store');
    Route::get('/faktor-risiko/show', [RiskFactorController::class, 'show'])->name('faktor-risiko.show');

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/deteksi-dini', [BreastExamController::class, 'index'])->name('deteksi-dini.index');
    Route::get('/deteksi-dini/create', [BreastExamController::class, 'create'])->name('deteksi-dini.create');
    Route::post('/deteksi-dini/create', [BreastExamController::class, 'store'])->name('deteksi-dini.store');
    Route::get('/deteksi-dini/show', [BreastExamController::class, 'show'])->name('deteksi-dini.show');

    Route::get('/laporan', [ReportController::class, 'index'])->name('report.index');

    Route::get('/pengaturan', [SettingsController::class, 'edit'])->name('pengaturan.edit');
    Route::post('/pengaturan', [SettingsController::class, 'update'])->name('pengaturan.update');
});

Route::prefix('api')->name('api.')->group(function () {
    Route::get('/risk-factors', [RiskFactorController::class, 'detect'])->name('risk-factors.detect');
    Route::get('/breast-exam', [BreastExamController::class, 'detect'])->name('breast-exam.detect');
});

Route::get('/', function () {
    return view('welcome');
});
