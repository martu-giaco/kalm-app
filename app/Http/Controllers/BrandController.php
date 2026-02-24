<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;


class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        // Vista principal
        return view('admin.brands.index', compact('brands'));
    }

    // Ver detalle de un usuario (route model binding posible)
    public function view(Brand $brand)
    {
        return view('admin.brands.view', compact('brand'));
    }

    //Formulario de edición.
    public function adminEdit($id)
    {
        $this->authorizeAdmin();
        $brand = Brand::findOrFail($id);

        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Actualizar marca //A ESTO LE FALTA, ES COPYPASTE DE USUARIO, HAY QUE ADAPTARLO A MARCA
     */
    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();
        $brand = Brand::findOrFail($id);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('brands')->ignore($brand->id)],
            'avatar' => ['nullable', 'image', 'max:2048'], // 2MB máximo
        ]);

        // Subida de avatar
        if ($request->hasFile('avatar')) {
            // Borrar avatar anterior si existe
            if ($brand->avatar) {
                Storage::disk('public')->delete($brand->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $path;
        }

        $brand->update($data);

        return redirect()->route('admin.brands.index')
            ->with('feedback.message', 'Marca actualizada correctamente')
            ->with('feedback.type', 'success');
    }

    // Eliminar marca
    public function adminDestroy($id)
    {
        $this->authorizeAdmin();
        $brand = Brand::findOrFail($id);
        $brand->delete();

        return redirect()->route('admin.brands.index')->with('success', 'La marca fue eliminada correctamente.');
    }

    private function authorizeAdmin()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'No tenés permiso para realizar esta acción.');
        }
    }
}
