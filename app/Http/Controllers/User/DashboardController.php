<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Resumen para el usuario: cantidad de campañas, visitas recientes, etc.
        return view('user.dashboard');
    }
}
