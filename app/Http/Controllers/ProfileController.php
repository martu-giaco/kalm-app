<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Routine;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    /**
     * Aplicar middleware en el constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Mostrar perfil del usuario autenticado.
     */
    public function show()
    {
        $user = auth()->user()->loadCount(['routines', 'reviews']); // quitar favoritos si es JSON

        // Traer rutinas del usuario
        $routines = $user->routines()->with('routineTime')->latest()->get();

        // Traer solo reviews hechas por el usuario
        $reviews = $user->reviews()->latest()->get(); // esto asume que tu relación 'reviews' está definida como reviews hechas por el user
        // Si tu relación 'reviews' devuelve reviews recibidas, hacé esto:
        // $reviews = \App\Models\Review::where('user_id', $user->id)->latest()->get();

        return view('user.profile', compact('user', 'routines', 'reviews'));
    }

    /**
     * Formulario de edición.
     */
    public function edit()
    {
        $user = auth()->user();
        return view('user.edit', compact('user'));
    }

    /**
     * Actualizar perfil (nombre, email, avatar).
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:10'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'avatar' => ['nullable', 'image', 'max:2048'], // 2MB máximo
        ]);

        // Subida de avatar
        if ($request->hasFile('avatar')) {
            // Borrar avatar anterior si existe
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $path;
        }

        $user->update($data);

        return redirect()->route('profile.show')
            ->with('feedback.message', 'Perfil actualizado correctamente')
            ->with('feedback.type', 'success');
    }

    /**
     * Actualizar contraseña del usuario.
     */
    public function password()
    {
        $user = auth()->user();
        return view('user.password', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = auth()->user();

        // Verificar contraseña actual
        if (! Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'La contraseña actual no es correcta.',
            ]);
        }

        // Guardar nueva contraseña
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('feedback.message', 'Contraseña actualizada correctamente.')
            ->with('feedback.type', 'success');
    }

    /**
     * Resultados del usuario.
     */
    public function results()
    {
        $user = auth()->user();

        // Cargar resultados de tests del usuario
        $results = $user->testResults()->latest()->get();

        return view('user.results', compact('results', 'user'));
    }

    // Eliminar usuario
    public function destroy()
    {
        $user = auth()->user()->delete();

        return redirect()->route('home')->with('success', 'Su cuenta fue eliminada correctamente.');
    }

    //-------------------------
    // ADMIN
    //-------------------------

    // Listar usuarios
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(25);
        return view('admin.users.index', compact('users'));
    }

    public function equipokalm()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(25);
        // Vista del equipo de Kälm
        return view('admin.equipokalm', compact('users'));
    }

    // Ver detalle de un usuario (route model binding posible)
    public function view(User $user)
    {
        return view('admin.users.view', compact('user'));
    }

    //Formulario de edición.
    public function adminEdit($id)
    {
        $this->authorizeAdmin();
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Actualizar perfil (nombre, email, avatar).
     */
    public function adminUpdate(Request $request, $id)
    {
        $this->authorizeAdmin();
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:10'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'avatar' => ['nullable', 'image', 'max:2048'], // 2MB máximo
            'role' => ['required', 'string', 'max:255'],
        ]);

        // Subida de avatar
        if ($request->hasFile('avatar')) {
            // Borrar avatar anterior si existe
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $path;
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('feedback.message', 'Perfil actualizado correctamente')
            ->with('feedback.type', 'success');
    }

    // Eliminar usuario
    public function adminDestroy($id)
    {
        $this->authorizeAdmin();
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'El usuario fue eliminado correctamente.');
    }

    private function authorizeAdmin()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'No tenés permiso para realizar esta acción.');
        }
    }
}
