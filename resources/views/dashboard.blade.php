@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Dashboard administrativo</h1>
            <p class="text-muted mb-0">Resumen general del repositorio documental académico.</p>
        </div>
        <a href="{{ route('documentos.create') }}" class="btn btn-primary">Subir documento</a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card stat-card shadow-sm">
                <div class="card-body">
                    <div class="text-muted">Total documentos</div>
                    <div class="display-6 fw-semibold">{{ $totalDocumentos }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card shadow-sm">
                <div class="card-body">
                    <div class="text-muted">Total usuarios</div>
                    <div class="display-6 fw-semibold">{{ $totalUsuarios }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card shadow-sm">
                <div class="card-body">
                    <div class="text-muted">Total semestres</div>
                    <div class="display-6 fw-semibold">{{ $totalSemestres }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white fw-semibold">Ultimos documentos cargados</div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Semestre</th>
                                <th>Usuario</th>
                                <th>Fecha</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ultimosDocumentos as $documento)
                                <tr>
                                    <td>{{ $documento->nombre }}</td>
                                    <td>{{ $documento->semestre->nombre }} {{ $documento->semestre->anio }}</td>
                                    <td>{{ $documento->usuario->name }}</td>
                                    <td>{{ $documento->fecha_subida->format('d/m/Y H:i') }}</td>
                                    <td class="text-end">
                                        <a class="btn btn-sm btn-outline-primary" href="{{ route('documentos.show', $documento) }}">Ver</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted py-4">No hay documentos cargados.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white fw-semibold">Documentos por tipo</div>
                <div class="card-body">
                    @forelse ($documentosPorExtension as $item)
                        <div class="d-flex justify-content-between border-bottom py-2">
                            <span class="text-uppercase">{{ $item->extension }}</span>
                            <span class="badge text-bg-primary">{{ $item->total }}</span>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Sin datos disponibles.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
