<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InstansiController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('instansi', InstansiController::class);

    Route::get('/evaluation-details/{id}/download', [EvaluationController::class, 'downloadFile'])->name('evaluations.download-file');
    Route::post('/evaluation-details/{id}/delete-file', [EvaluationController::class, 'deleteFile'])->name('evaluations.delete-file');

    Route::resource('evaluations', EvaluationController::class);

    Route::patch('/evaluations/{evaluation}/submit', [EvaluationController::class, 'submit'])->name('evaluations.submit');
    Route::patch('/evaluations/{evaluation}/approve', [EvaluationController::class, 'approve'])->name('evaluations.approve');
    Route::patch('/evaluations/{evaluation}/reject', [EvaluationController::class, 'reject'])->name('evaluations.reject');

    Route::resource('users', UserController::class);
});
