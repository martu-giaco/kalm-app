<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\Storage;


class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        // Vista principal
        return view('admin.brands.index', compact('brands'));
    }

    // Ver detalle de una marca
    public function view(Brand $brand)
    {
        return view('admin.brands.view', compact('brand'));
    }

        // Formulario para crear marca (solo admin)
    public function create()
    {
        $this->authorizeAdmin();
        return view('admin.brands.create');
    }

    public function adminIndex()
    {
        $brands = Brand::orderByDesc('created_at')->get();
        return view('admin.brands.index', compact('brands'));
    }

    // Guardar nueva marca (solo admin)
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:2048'], // 2MB máximo
        ]);

        // Subida de imagen
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $path;
        }

        Brand::create($validated);

        return redirect()->route('admin.brands.index')->with('success', 'Marca creada correctamente.');
    }

    //Formulario de edición.
    public function adminEdit($id)
    {
        $this->authorizeAdmin();
        $brand = Brand::findOrFail($id);

        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Actualizar marca
     */
    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();
        $brand = Brand::findOrFail($id);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:2048'], // 2MB máximo
        ]);

        // Subida de logo
        if ($request->hasFile('logo')) {
            // Borrar logo anterior si existe
            if ($brand->logo) {
                Storage::disk('public')->delete($brand->logo);
            }
            $path = $request->file('logo')->store('logos', 'public');
            $data['logo'] = $path;
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
