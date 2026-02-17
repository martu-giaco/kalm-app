<?php

namespace App\Http\Controllers;

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

    /**
     * Formulario de edición.
     */
    public function edit()
    {
        $user = auth()->user();
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Actualizar perfil (nombre, email, avatar).
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
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

        return redirect()->route('admin.users.index')
            ->with('feedback.message', 'Perfil actualizado correctamente')
            ->with('feedback.type', 'success');
    }

    // Eliminar usuario
    public function destroy()
    {
        $user = auth()->user()->delete();

        return redirect()->route('admin.users.index')->with('success', 'El usuario fue eliminado correctamente.');
    }
}
