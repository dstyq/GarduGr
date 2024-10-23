<?php

use App\Http\Controllers\AuthController; 
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\HistoryLogController;
use App\Http\Controllers\GarduController; 
use App\Http\Controllers\ImpedansiTrafoController; 
use Illuminate\Support\Facades\Route;

// Rute untuk halaman login
Route::get('/', function () {
    return view('auth.login', ['page_title' => 'Login']);
})->name('user.login');

// Rute untuk memproses login
Route::post('login', [AuthController::class, 'login'])->name('user.login.post');

// Grup rute yang memerlukan otentikasi
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard.index');

    // Master Data
    Route::get('master-data', function () {
        return view('master-data.index', [
            'page_title' => 'Master Data',
            'breadcumb' => 'Master Data'
        ]);
    })->name('master-data.index');

    // Departemen
    Route::resource('departements', DepartementController::class);

    // Pengguna
    Route::patch('change-password', [UserController::class, 'changePassword'])->name('users.change-password');
    Route::resource('users', UserController::class)->except('show');

    // History Log
    Route::resource('history-log', HistoryLogController::class)->except(['show', 'create', 'store', 'edit', 'update']);

    // Gardu
    Route::resource('gardu', GarduController::class);

    // Impedansi Trafo
    Route::resource('impedansi-trafo', ImpedansiTrafoController::class);
});
