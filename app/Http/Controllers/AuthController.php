<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * AuthController constructor.
     * Middleware 'auth' por defecto a todas las acciones excepto las públicas.
     */
    public function __construct()
    {
        $this->middleware('auth')->except([
            'logOrReg',
            'login',
            'authenticate',
            'register',
            'store',
            'redirectToGoogle',     
            'handleGoogleCallback',
        ]);
    }

    /**
     * Mostrar pantalla login o registrarse (vista híbrida).
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
     */
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.login');
    }

    /**
     * Procesar login tradicional.
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user && isset($user->role) && $user->role === 'admin') {
                return redirect()
                    ->route('admin.home')
                    ->with('feedback.message', 'Sesión iniciada con éxito.');
            }

            return redirect()
                ->intended(route('home'))
                ->with('feedback.message', 'Sesión iniciada con éxito.');
        }

        throw ValidationException::withMessages([
            'email' => ['Las credenciales ingresadas no coinciden con nuestros registros.'],
        ])->redirectTo(route('auth.login'));
    }

    /**
     * Mostrar formulario de registro.
     */
    public function register()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.register');
    }

    /**
     * Procesar registro (almacena en sesión antes de aceptación de términos).
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:10',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        session([
            'registration' => [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
            ],
            'registration_created_at' => now()->toDateTimeString(),
        ]);

        return redirect()
            ->route('auth.terms.show')
            ->with('feedback.message', 'Por favor, revisar y aceptar los Términos y Condiciones para continuar con el registro.');
    }

    /**
     * Cierre de sesión.
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
     * Listar usuarios (Admin).
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * Ver un usuario por ID.
     */
    public function view($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.view', compact('user'));
    }

    /**
     * Redirige al usuario a la autenticación de Google con permisos de Calendar.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->scopes(['https://www.googleapis.com/auth/calendar.events'])
            ->with(['access_type' => 'offline', 'prompt' => 'consent'])
            ->redirect();
    }

    /**
     * Recibe la respuesta Callback de Google.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // CASO A: El usuario ya está autenticado en la app y está vinculando su cuenta de Google Calendar
            if (Auth::check()) {
                $user = Auth::user();
                $user->update([
                    'google_id'            => $googleUser->getId(),
                    'google_token'         => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken ?? $user->google_refresh_token,
                ]);

                return redirect()->route('routines.create')
                    ->with('feedback', [
                        'message' => '¡Cuenta de Google Calendar vinculada con éxito! 🎉',
                        'type' => 'success'
                    ]);
            }

            // CASO B: El usuario no ha iniciado sesión (Login o Registro mediante Google)
            $user = User::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())
                ->first();

            if ($user) {
                // Actualizar credenciales y preservación del refresh_token
                $user->update([
                    'google_id'            => $googleUser->getId(),
                    'google_access_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken ?? $user->google_refresh_token,
                ]);
            } else {
                // Formatear nombre seguro respetando la longitud
                $rawName = $googleUser->getName() ?? $googleUser->getNickname() ?? 'Usuario';
                $formattedName = Str::limit($rawName, 10, '');

                session([
                    'registration' => [
                        'provider'             => 'google',
                        'name'                 => !empty($formattedName) ? $formattedName : 'Usuario',
                        'email'                => $googleUser->getEmail(),
                        'google_id'            => $googleUser->getId(),
                        'google_access_token'  => $googleUser->token,
                        'google_refresh_token' => $googleUser->refreshToken,
                    ],
                    'registration_created_at' => now()->toDateTimeString(),
                ]);

                return redirect()
                    ->route('auth.terms.show')
                    ->with('feedback.message', 'Para finalizar el registro, aceptá los Términos y Condiciones.');
            }

            // Iniciar sesión y recordar usuario
            Auth::login($user, true);

            return redirect()
                ->intended(route('home'))
                ->with('feedback.message', '¡Bienvenida/o! Sesión iniciada con Google.');

        } catch (\Exception $e) {
            if (config('app.debug')) {
                throw $e;
            }

            return redirect()
                ->route('auth.login')
                ->with('error', 'Ocurrió un inconveniente al conectar con Google. Por favor, intentá nuevamente.');
        }
    }
}