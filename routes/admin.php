<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ApiConfigController;
use App\Http\Controllers\Admin\SubscriptionController;

// Middleware 'auth' para asegurar que está logueado
// Middleware personalizado (ej. 'role:admin') para asegurar que es admin
Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/{user}/suspend', [UserController::class, 'suspend'])->name('admin.users.suspend');
    
    Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('admin.subscriptions.index');
    Route::post('/subscriptions/{user}/extend', [SubscriptionController::class, 'extend'])->name('admin.subscriptions.extend');

    Route::get('/api-config', [ApiConfigController::class, 'edit'])->name('admin.api_config.edit');
    Route::post('/api-config', [ApiConfigController::class, 'update'])->name('admin.api_config.update');
});
