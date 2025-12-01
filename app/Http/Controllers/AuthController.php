<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Mostrar formulario de login
    public function login()
    {
        return view('auth.login');
    }

    // Procesar login (mantengo tu implementación)
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            // Seguridad: regenerar sesión para evitar fixation
            $request->session()->regenerate();

            return redirect()
                ->intended(route('home'))
                ->with('feedback.message', 'Sesión iniciada con éxito.');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Las credenciales ingresadas no coinciden con nuestros registros.']);
    }


    // Mostrar formulario de registro
    public function register()
    {
        return view('auth.register');
    }

    // Procesar registro
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'free',
        ]);

        return redirect()
            ->route('auth.login')
            ->with('feedback.message', 'Cuenta creada correctamente. Inicia sesión.')
            ->with('feedback.type', 'success')
            ->with('status', 'Cuenta creada correctamente. Inicia sesión.');

    }



    // Logout (mantengo tu implementación)
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();


        return redirect()
            ->route('auth.login')
            ->with('feedback.message', 'Sesión cerrada.');
    }

    public function index()
    {
        $users = User::all();
        return view('users.index', ['users' => $users]);
    }

    public function view($id)
    {
        $user = User::findOrFail($id); // Usa la clave primaria 'id'

        return view('users.view', compact('user'));
    }
}
