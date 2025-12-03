<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Listar usuarios
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(25);
        return view('admin.users.index', compact('users'));
    }

    // Ver detalle de un usuario (route model binding posible)
    public function view(User $user)
    {
        return view('admin.users.view', compact('user'));
    }
}
