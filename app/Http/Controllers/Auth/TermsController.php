<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class TermsController extends Controller
{
    // Mostrar la vista terms (views/auth/terms.blade.php)
    public function show()
    {
        // Opcional: si no hay datos de registro en sesión, redirigimos al registro
        if (!session()->has('registration')) {
            return redirect()->route('auth.register')
                ->with('feedback.message', 'Completá el formulario de registro primero.');
        }

        // Cargamos los términos (la vista contendrá el checkbox y el form)
        return view('auth.terms');
    }

    // Procesar aceptación de términos y crear usuario
    public function accept(Request $request)
    {
        $request->validate([
            'accept_terms' => 'required|accepted'
        ], [
            'accept_terms.required' => 'Debés aceptar los Términos y Condiciones para registrarte.',
            'accept_terms.accepted' => 'Debés aceptar los Términos y Condiciones para registrarte.',
        ]);

        $data = session('registration');

        if (!$data) {
            return redirect()->route('auth.register')
                ->with('feedback.message', 'La información de registro expiró. Volvé a completar el formulario.');
        }

        // Crear usuario (hasheando contraseña)
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'accepted_terms' => true,
            'terms_accepted_at' => Carbon::now(),
            // otros campos opcionales
        ]);

        // Limpiar datos de sesión
        session()->forget('registration');

        // Loguear al usuario automáticamente
        auth()->login($user);

        return redirect()->route('home');
    }
}
