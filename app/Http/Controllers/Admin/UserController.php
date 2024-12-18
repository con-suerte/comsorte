<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        // Lista de usuarios.
        $users = User::with('roles')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function suspend(User $user)
    {
        // Suspender usuario (set is_active = false)
        $user->update(['is_active' => false]);
        return redirect()->route('admin.users.index')->with('status', 'Usuario suspendido.');
    }
}
