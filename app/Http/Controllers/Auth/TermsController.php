<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TermsController extends Controller
{
    // Mostrar la vista terms (views/auth/terms.blade.php)
    public function show()
    {

        if (!session()->has('registration')) {
            return redirect()->route('auth.register')
                ->with('feedback.message', 'Completá el formulario de registro primero.');
        }

        return view('auth.terms');
    }

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

        $userData = [
            'name' => $data['name'] ?? '',
            'email' => $data['email'] ?? '',
            'password' => Hash::make($data['password'] ?? Str::random(24)),
            'accepted_terms' => true,
            'terms_accepted_at' => Carbon::now(),
        ];

        if (($data['provider'] ?? null) === 'google') {
            $userData['google_id'] = $data['google_id'] ?? null;
            $userData['google_access_token'] = $data['google_access_token'] ?? null;
            $userData['google_refresh_token'] = $data['google_refresh_token'] ?? null;
            $userData['role'] = 'free';
        }

        $user = User::create($userData);

        // Limpiar datos de sesión
        session()->forget('registration');

        // Loguear al usuario automáticamente
        auth()->login($user);

        return redirect()->route('tests.intro');
    }
}
