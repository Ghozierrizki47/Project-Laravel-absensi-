<?php

use App\Http\Controllers\AbsenController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\PresenceDetailController;
use App\Http\Controllers\RekapBulananController;
use App\Http\Controllers\SystemSettingsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Redirect root to home (dashboard)
Route::get('/', function () {
    return redirect()->route('home');
});

// Auth routes
Auth::routes([
    'register' => false,
    'reset' => false
]);

// Protected routes (requires authentication)
Route::middleware('auth')->group(function () {
    // Dashboard Home
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    // Presence CRUD
    Route::resource('presence', PresenceController::class);
    
    // Presence Detail
    Route::delete('presence-detail/{id}', [PresenceDetailController::class, 'destroy'])->name('presence-detail.destroy');
    Route::get('presence-detail/export-pdf/{id}', [PresenceDetailController::class, 'exportPdf'])->name('presence-detail.export-pdf');
    
    // Settings/Bantuan
    Route::get('/settings', function() {
        return view('pages.settings');
    })->name('settings');
    
    // System Settings (Pengaturan Sistem)
    Route::get('/system-settings', [SystemSettingsController::class, 'index'])->name('system-settings');
    Route::post('/system-settings/clear-cache', [SystemSettingsController::class, 'clearCache'])->name('system-settings.clear-cache');
    
    // Rekap Bulanan
    Route::get('/rekap-bulanan', [RekapBulananController::class, 'index'])->name('rekap-bulanan');
    Route::get('/rekap-bulanan/export', [RekapBulananController::class, 'export'])->name('rekap-bulanan.export');
    
    // Laporan (Sakit, Izin, Cuti, dll)
    Route::resource('laporan', LaporanController::class);
    Route::post('laporan/{laporan}/update-status', [LaporanController::class, 'updateStatus'])->name('laporan.updateStatus');
});

// Public routes (tidak perlu login)
Route::get('absen/{slug}', [AbsenController::class, 'index'])->name('absen.index');
Route::post('absen/{slug}/save', [AbsenController::class, 'save'])->name('absen.save');
