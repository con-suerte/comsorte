<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Aquí mostraremos un resumen global: cantidad de usuarios, campañas totales, etc.
        // Por ahora, devolvemos una vista base.
        return view('admin.dashboard');
    }
}
