<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Aplicar middleware en el constructor.
     */
    public function __construct()
    {
        // <-- la llamada middleware() funciona porque extendemos Controller
        $this->middleware('auth');
    }

    /**
     * Mostrar perfil del usuario autenticado.
     */
    public function show()
    {
        $user = auth()->user();
        return view('user.profile', compact('user'));

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
     * Actualizar perfil.
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('avatar')) {
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
}
