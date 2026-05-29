<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSemestreRequest;
use App\Http\Requests\UpdateSemestreRequest;
use App\Models\Semestre;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SemestreController extends Controller
{
    public function index(): View
    {
        $semestres = Semestre::withCount(['carpetas', 'documentos'])
            ->orderByDesc('anio')
            ->orderBy('nombre')
            ->paginate(10);

        return view('semestres.index', compact('semestres'));
    }

    public function create(): View
    {
        abort_unless(auth()->user()?->can('semestres.crear'), 403);

        return view('semestres.create', ['semestre' => new Semestre()]);
    }

    public function store(StoreSemestreRequest $request): RedirectResponse
    {
        Semestre::create($request->validated() + ['activo' => $request->boolean('activo')]);

        return redirect()->route('semestres.index')->with('success', 'Semestre creado correctamente.');
    }

    public function show(Semestre $semestre): View
    {
        $semestre->load(['carpetas' => fn ($query) => $query->whereNull('parent_id')->with('subcarpetas'), 'documentos.usuario']);

        return view('semestres.show', compact('semestre'));
    }

    public function edit(Semestre $semestre): View
    {
        abort_unless(auth()->user()?->can('semestres.editar'), 403);

        return view('semestres.edit', compact('semestre'));
    }

    public function update(UpdateSemestreRequest $request, Semestre $semestre): RedirectResponse
    {
        $semestre->update($request->validated() + ['activo' => $request->boolean('activo')]);

        return redirect()->route('semestres.index')->with('success', 'Semestre actualizado correctamente.');
    }

    public function destroy(Semestre $semestre): RedirectResponse
    {
        abort_unless(auth()->user()?->can('semestres.eliminar'), 403);

        $semestre->delete();

        return redirect()->route('semestres.index')->with('success', 'Semestre eliminado correctamente.');
    }
}
