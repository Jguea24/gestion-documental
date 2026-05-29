@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">{{ $semestre->nombre }} {{ $semestre->anio }}</h1>
            <span class="badge {{ $semestre->activo ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $semestre->activo ? 'Activo' : 'Inactivo' }}</span>
        </div>
        <a href="{{ route('semestres.index') }}" class="btn btn-outline-secondary">Volver</a>
    </div>
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm"><div class="card-header bg-white fw-semibold">Carpetas</div><div class="card-body">
                @include('partials.folder-tree', ['carpetas' => $semestre->carpetas])
            </div></div>
        </div>
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-semibold">Documentos</div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead><tr><th>Nombre</th><th>Tipo</th><th>Usuario</th><th></th></tr></thead>
                        <tbody>
                            @forelse ($semestre->documentos as $documento)
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
