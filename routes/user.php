<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\CampaignController;
use App\Http\Controllers\User\StatsController;
use App\Http\Controllers\User\FilterFileController;

// Middleware 'auth' para asegurar que está logueado
// Suponemos que cualquier usuario logueado puede crear campañas. Si queremos limitar solo a rol 'user':
// Route::middleware(['auth','role:user|admin'])->group(function () { ... }
Route::middleware(['auth'])->group(function () {
    Route::get('/', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/campaigns', [CampaignController::class, 'index'])->name('user.campaigns.index');
    Route::get('/campaigns/create', [CampaignController::class, 'create'])->name('user.campaigns.create');
    Route::post('/campaigns', [CampaignController::class, 'store'])->name('user.campaigns.store');
    Route::get('/campaigns/{campaign}', [CampaignController::class, 'edit'])->name('user.campaigns.edit');
    Route::post('/campaigns/{campaign}', [CampaignController::class, 'update'])->name('user.campaigns.update');
    Route::delete('/campaigns/{campaign}', [CampaignController::class, 'destroy'])->name('user.campaigns.destroy');

    Route::get('/campaigns/{campaign}/stats', [StatsController::class, 'index'])->name('user.campaigns.stats');

    // Generar/descargar filter.php
    Route::get('/campaigns/{campaign}/filter-file', [FilterFileController::class, 'download'])->name('user.campaigns.filterfile');
});
