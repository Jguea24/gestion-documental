<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentoRequest;
use App\Http\Requests\UpdateDocumentoRequest;
use App\Models\Carpeta;
use App\Models\Documento;
use App\Models\Semestre;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentoController extends Controller
{
    public function index(Request $request): View
    {
        $documentos = Documento::with(['semestre', 'carpeta', 'usuario'])
            ->when($request->filled('nombre'), fn ($query) => $query->where('nombre', 'like', '%'.$request->string('nombre')->toString().'%'))
            ->when($request->filled('semestre_id'), fn ($query) => $query->where('semestre_id', $request->integer('semestre_id')))
            ->when($request->filled('extension'), fn ($query) => $query->where('extension', $request->string('extension')->toString()))
            ->when($request->filled('usuario_id'), fn ($query) => $query->where('usuario_id', $request->integer('usuario_id')))
            ->latest('fecha_subida')
            ->paginate(12)
            ->withQueryString();

        return view('documentos.index', [
            'documentos' => $documentos,
            'semestres' => Semestre::orderByDesc('anio')->orderBy('nombre')->get(),
            'usuarios' => User::orderBy('name')->get(),
            'extensiones' => Documento::query()->select('extension')->distinct()->orderBy('extension')->pluck('extension'),
            'filters' => $request->only(['nombre', 'semestre_id', 'extension', 'usuario_id']),
        ]);
    }

    public function create(): View
    {
        abort_unless(auth()->user()?->can('documentos.crear'), 403);

        return view('documentos.create', $this->formData(new Documento()));
    }

    public function store(StoreDocumentoRequest $request): RedirectResponse
    {
        $file = $request->file('archivo');
        $path = $file->store('documentos', 'public');

        Documento::create($request->safe()->except('archivo') + [
            'usuario_id' => $request->user()->id,
            'archivo' => $path,
            'extension' => strtolower($file->getClientOriginalExtension()),
            'tamano' => $file->getSize(),
            'fecha_subida' => now(),
        ]);

        return redirect()->route('documentos.index')->with('success', 'Documento cargado correctamente.');
    }

    public function show(Documento $documento): View
    {
        $documento->load(['semestre', 'carpeta', 'usuario']);

        return view('documentos.show', compact('documento'));
    }

    public function edit(Documento $documento): View
    {
        abort_unless(auth()->user()?->can('documentos.editar'), 403);

        return view('documentos.edit', $this->formData($documento));
    }

    public function update(UpdateDocumentoRequest $request, Documento $documento): RedirectResponse
    {
        $data = $request->safe()->except('archivo');

        if ($request->hasFile('archivo')) {
            Storage::disk('public')->delete($documento->archivo);

            $file = $request->file('archivo');
            $data += [
                'archivo' => $file->store('documentos', 'public'),
                'extension' => strtolower($file->getClientOriginalExtension()),
                'tamano' => $file->getSize(),
            ];
        }

        $documento->update($data);

        return redirect()->route('documentos.index')->with('success', 'Documento actualizado correctamente.');
    }

    public function destroy(Documento $documento): RedirectResponse
    {
        abort_unless(auth()->user()?->can('documentos.eliminar'), 403);

        Storage::disk('public')->delete($documento->archivo);
        $documento->delete();

        return redirect()->route('documentos.index')->with('success', 'Documento eliminado correctamente.');
    }

    public function download(Documento $documento): StreamedResponse
    {
        abort_unless(auth()->user()?->can('documentos.descargar'), 403);

        return Storage::disk('public')->download($documento->archivo, $documento->nombre.'.'.$documento->extension);
    }

    public function preview(Documento $documento): View
    {
        abort_unless(auth()->user()?->can('documentos.ver'), 403);
        abort_unless($documento->extension === 'pdf', 404);

        return view('documentos.preview', compact('documento'));
    }

    private function formData(Documento $documento): array
    {
        return [
            'documento' => $documento,
            'semestres' => Semestre::where('activo', true)->orderByDesc('anio')->orderBy('nombre')->get(),
            'carpetas' => Carpeta::with('semestre')->orderBy('nombre')->get(),
        ];
    }
}
