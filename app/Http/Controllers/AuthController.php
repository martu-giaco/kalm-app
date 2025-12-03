<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * AuthController constructor.
     *
     * Aplicamos middleware 'auth' por defecto a todas las acciones y
     * eximimos únicamente las que deben ser públicas para el flujo de
     * autenticación/registro.
     */
    public function __construct()
    {
        // Todas las rutas requieren auth excepto las listadas en except()
        $this->middleware('auth')->except([
            'logOrReg',
            'login',
            'authenticate',
            'register',
            'store',
        ]);
    }

    /**
     * Mostrar pantalla login o registrarse (vista híbrida).
     * Si el usuario ya está autenticado lo redirigimos al home.
     */
    public function logOrReg()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.logreg');
    }

    /**
     * Mostrar formulario de login.
     * Si el usuario ya está autenticado lo redirigimos al home.
     */
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.login');
    }

    /**
     * Procesar login.
     */
    public function authenticate(Request $request)
    {
        // Validación básica
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Intentamos autenticar
        if (Auth::attempt($credentials)) {
            // Regenerar sesión por seguridad
            $request->session()->regenerate();

            // Redirigir al intended o a home
            return redirect()
                ->intended(route('home'))
                ->with('feedback.message', 'Sesión iniciada con éxito.');
        }

        // Si falla la autenticación devolvemos error
        throw ValidationException::withMessages([
            'email' => ['Las credenciales ingresadas no coinciden con nuestros registros.'],
        ])->redirectTo(route('auth.login'));
    }

    /**
     * Mostrar formulario de registro.
     * Si el usuario ya está autenticado lo redirigimos al home.
     */
    public function register()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.register');
    }

    /**
     * Procesar registro (guardamos temporalmente en sesión y redirigimos a Términos).
     *
     * NOTA: Guardamos la contraseña en sesión temporalmente para poder crear el usuario
     * luego de que acepte los términos. La sesión debe expirar si el usuario no completa
     * el flujo; en producción podés considerar alternativas (crear usuario "pendiente").
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Guardamos los datos de registro temporalmente en sesión
        session([
            'registration' => [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'], // temporal; se hasheará al crear el usuario
            ],
            // opcional: guardamos timestamp para expiración manual
            'registration_created_at' => now()->toDateTimeString(),
        ]);

        // Redirigir a la vista de términos para que el usuario acepte
        return redirect()
            ->route('auth.terms.show')
            ->with('feedback.message', 'Por favor, revisá y aceptá los Términos y Condiciones para continuar con el registro.');
    }

    /**
     * Logout.
     *
     * Protegido por auth (constructor). Cierra sesión y redirige al login.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('auth.login')
            ->with('feedback.message', 'Sesión cerrada.');
    }

    /**
     * Listar usuarios (index).
     *
     * Protegido por auth (constructor). Si necesitás además admin-only, aplicá un middleware extra.
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', ['users' => $users]);
    }

    /**
     * Ver un usuario por id.
     *
     * Protegido por auth (constructor).
     */
    public function view($id)
    {
        $user = User::findOrFail($id);
        return view('users.view', compact('user'));
    }
}
