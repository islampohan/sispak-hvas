<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Teknisi\DashboardController as TeknisiDashboardController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\Teknisi\GejalaController;
use App\Http\Controllers\Teknisi\KerusakanController;
use App\Http\Controllers\Teknisi\AturanController;
use App\Http\Controllers\Teknisi\SolusiController;
use App\Http\Controllers\User\DiagnosaController;
use App\Http\Controllers\User\RiwayatController;
use App\Http\Controllers\User\PredictiveMaintenanceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route publik
Route::get('/', function () {
    return view('welcome');
});

// Rute autentikasi
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rute registrasi
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Rute yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    // Home & Dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rute untuk Admin
    Route::prefix('admin')->middleware('admin')->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // Pengguna
        Route::resource('users', UserController::class);
    });

    // Rute untuk Teknisi
    Route::prefix('teknisi')->middleware('teknisi')->group(function () {
        // Dashboard
        Route::get('/dashboard', [TeknisiDashboardController::class, 'index'])->name('teknisi.dashboard');

        // Gejala
        Route::resource('gejala', GejalaController::class);

        // Kerusakan
        Route::resource('kerusakan', KerusakanController::class);

        // Aturan
        Route::resource('aturan', AturanController::class);
        Route::post('/aturan/{aturan}/gejala', [AturanController::class, 'addGejala'])->name('aturan.gejala.add');
        Route::delete('/aturan/{aturan}/gejala/{gejala}', [AturanController::class, 'removeGejala'])->name('aturan.gejala.remove');

        // Solusi
        Route::resource('solusi', SolusiController::class);
    });

    // Rute untuk User Biasa
    Route::prefix('user')->middleware('user')->group(function () {
        // Dashboard
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');

        // Diagnosa
        Route::get('/diagnosa', [DiagnosaController::class, 'index'])->name('diagnosa.index');
        Route::post('/diagnosa', [DiagnosaController::class, 'process'])->name('diagnosa.process');
        Route::get('/diagnosa/hasil', [DiagnosaController::class, 'result'])->name('diagnosa.result');

        // Riwayat Konsultasi
        Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
        Route::get('/riwayat/{konsultasi}', [RiwayatController::class, 'show'])->name('riwayat.show');
        Route::get('/riwayat/{konsultasi}/pdf', [RiwayatController::class, 'generatePdf'])->name('riwayat.pdf');

        // Predictive Maintenance
        Route::get('/predictive-maintenance', [PredictiveMaintenanceController::class, 'index'])->name('predictive-maintenance.index');
        Route::post('/predictive-maintenance', [PredictiveMaintenanceController::class, 'calculate'])->name('predictive-maintenance.calculate');
        Route::get('/predictive-maintenance/hasil', [PredictiveMaintenanceController::class, 'result'])->name('predictive-maintenance.result');
    });
});
