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
        //TODO: Validar

        $credentials = $request->only(['email', 'password']);

        if(Auth::attempt($credentials)){
            return redirect()
                ->intended(route('home'))
                ->with('feedback.message', 'Sesión Iniciada con éxito. ¡Bienvenido de nuevo!');
        }

        return redirect()
                ->back()
                ->withInput()
                ->with('feedback.message', 'Las credenciales ingresadas no coinciden con nuestros registros!');
    }

    // Mostrar formulario de registro
    public function register()
    {
        return view('auth.register');
    }

    // Procesar registro
    public function store(Request $request)
    {
        // Validación
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Crear usuario
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Loguear al usuario recién creado
        Auth::login($user);

        return redirect()
            ->route('home')
            ->with('feedback.message', 'Registro exitoso. ¡Bienvenido!')
            ->with('feedback.type', 'success');
    }

    // Logout (mantengo tu implementación)
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();


        return redirect()
            ->route('auth.login')
            ->with('feedback.message', 'Sesion Cerrada con exito ¡Te esperamos pronto!');
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
