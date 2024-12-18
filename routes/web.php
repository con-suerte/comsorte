<?php
require __DIR__.'/auth.php';
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Install\InstallController;

Route::prefix('install')->middleware('web')->group(function () {
    Route::get('/', [InstallController::class, 'welcome'])->name('install.welcome');
    Route::post('/check-requirements', [InstallController::class, 'checkRequirements'])->name('install.checkRequirements');
    Route::get('/db-config', [InstallController::class, 'dbConfigForm'])->name('install.dbConfigForm');
    Route::post('/db-config', [InstallController::class, 'saveDbConfig'])->name('install.saveDbConfig');
    Route::get('/migrate', [InstallController::class, 'migrate'])->name('install.migrate');
    Route::get('/admin-user', [InstallController::class, 'adminUserForm'])->name('install.adminUserForm');
    Route::post('/admin-user', [InstallController::class, 'createAdminUser'])->name('install.createAdminUser');
    Route::get('/finish', [InstallController::class, 'finish'])->name('install.finish');
});

require __DIR__.'/admin.php';
require __DIR__.'/user.php';
