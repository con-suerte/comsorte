<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        // Por defecto, Laravel carga routes/web.php y routes/api.php
        // Nosotros agregamos routes/admin.php y routes/user.php desde web.php (con require)
        // No hace falta modificar.
    }
}
