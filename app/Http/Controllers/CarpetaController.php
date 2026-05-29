<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarpetaRequest;
use App\Http\Requests\UpdateCarpetaRequest;
use App\Models\Carpeta;
use App\Models\Semestre;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CarpetaController extends Controller
{
    public function index(): View
    {
        $carpetas = Carpeta::with(['semestre', 'padre'])
            ->withCount(['subcarpetas', 'documentos'])
            ->latest()
            ->paginate(12);

        return view('carpetas.index', compact('carpetas'));
    }

    public function create(): View
    {
        abort_unless(auth()->user()?->can('carpetas.crear'), 403);

        return view('carpetas.create', $this->formData(new Carpeta()));
    }

    public function store(StoreCarpetaRequest $request): RedirectResponse
    {
        Carpeta::create($request->validated());

        return redirect()->route('carpetas.index')->with('success', 'Carpeta creada correctamente.');
    }

    public function show(Carpeta $carpeta): View
    {
        $carpeta->load(['semestre', 'padre', 'subcarpetas', 'documentos.usuario']);

        return view('carpetas.show', compact('carpeta'));
    }

    public function edit(Carpeta $carpeta): View
    {
        abort_unless(auth()->user()?->can('carpetas.editar'), 403);

        return view('carpetas.edit', $this->formData($carpeta));
    }

    public function update(UpdateCarpetaRequest $request, Carpeta $carpeta): RedirectResponse
    {
        $carpeta->update($request->validated());

        return redirect()->route('carpetas.index')->with('success', 'Carpeta actualizada correctamente.');
    }

    public function destroy(Carpeta $carpeta): RedirectResponse
    {
        abort_unless(auth()->user()?->can('carpetas.eliminar'), 403);

        $carpeta->delete();

        return redirect()->route('carpetas.index')->with('success', 'Carpeta eliminada correctamente.');
    }

    private function formData(Carpeta $carpeta): array
    {
        return [
            'carpeta' => $carpeta,
            'semestres' => Semestre::where('activo', true)->orderByDesc('anio')->orderBy('nombre')->get(),
            'carpetasPadre' => Carpeta::with('semestre')
                ->when($carpeta->exists, fn ($query) => $query->whereKeyNot($carpeta->id))
                ->orderBy('nombre')
                ->get(),
        ];
    }
}
