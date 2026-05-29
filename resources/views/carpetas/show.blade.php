@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">{{ $carpeta->nombre }}</h1>
            <p class="text-muted mb-0">{{ $carpeta->semestre->nombre }} {{ $carpeta->semestre->anio }} / {{ $carpeta->padre?->nombre ?? 'Raiz' }}</p>
        </div>
        <a href="{{ route('carpetas.index') }}" class="btn btn-outline-secondary">Volver</a>
    </div>
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm"><div class="card-header bg-white fw-semibold">Subcarpetas</div><div class="card-body">
                @if ($carpeta->subcarpetas->isNotEmpty())
                    @include('partials.folder-tree', ['carpetas' => $carpeta->subcarpetas])
                @else
                    <p class="text-muted mb-0">No hay subcarpetas.</p>
                @endif
            </div></div>
        </div>
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-semibold">Documentos</div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead><tr><th>Nombre</th><th>Tipo</th><th>Usuario</th><th></th></tr></thead>
                        <tbody>
                            @forelse ($carpeta->documentos as $documento)
                                <tr>
                                    <td>{{ $documento->nombre }}</td>
                                    <td class="text-uppercase">{{ $documento->extension }}</td>
                                    <td>{{ $documento->usuario->name }}</td>
                                    <td class="text-end"><a class="btn btn-sm btn-outline-primary" href="{{ route('documentos.show', $documento) }}">Ver</a></td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-4">No hay documentos.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
