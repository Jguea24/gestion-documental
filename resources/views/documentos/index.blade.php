@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Documentos</h1>
        @can('documentos.crear')
            <a href="{{ route('documentos.create') }}" class="btn btn-primary">Subir documento</a>
        @endcan
    </div>

    <form method="GET" class="card border-0 shadow-sm mb-4">
        <div class="card-body row g-3">
            <div class="col-md-3"><input name="nombre" class="form-control" placeholder="Buscar por nombre" value="{{ $filters['nombre'] ?? '' }}"></div>
            <div class="col-md-3">
                <select name="semestre_id" class="form-select">
                    <option value="">Todos los semestres</option>
                    @foreach ($semestres as $semestre)
                        <option value="{{ $semestre->id }}" @selected(($filters['semestre_id'] ?? '') == $semestre->id)>{{ $semestre->nombre }} {{ $semestre->anio }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="extension" class="form-select">
                    <option value="">Todos los tipos</option>
                    @foreach ($extensiones as $extension)
                        <option value="{{ $extension }}" @selected(($filters['extension'] ?? '') === $extension)>{{ strtoupper($extension) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="usuario_id" class="form-select">
                    <option value="">Todos los usuarios</option>
                    @foreach ($usuarios as $usuario)
                        <option value="{{ $usuario->id }}" @selected(($filters['usuario_id'] ?? '') == $usuario->id)>{{ $usuario->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-grid"><button class="btn btn-outline-primary">Buscar</button></div>
        </div>
    </form>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead><tr><th>Nombre</th><th>Semestre</th><th>Carpeta</th><th>Tipo</th><th>Usuario</th><th>Fecha</th><th></th></tr></thead>
                <tbody>
                    @forelse ($documentos as $documento)
                        <tr>
                            <td>{{ $documento->nombre }}</td>
                            <td>{{ $documento->semestre->nombre }} {{ $documento->semestre->anio }}</td>
                            <td>{{ $documento->carpeta->nombre }}</td>
                            <td class="text-uppercase">{{ $documento->extension }}</td>
                            <td>{{ $documento->usuario->name }}</td>
                            <td>{{ $documento->fecha_subida->format('d/m/Y') }}</td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-outline-primary" href="{{ route('documentos.show', $documento) }}">Ver</a>
                                @can('documentos.editar') <a class="btn btn-sm btn-outline-secondary" href="{{ route('documentos.edit', $documento) }}">Editar</a> @endcan
                                @can('documentos.eliminar')
                                    <form method="POST" action="{{ route('documentos.destroy', $documento) }}" class="d-inline" onsubmit="return confirm('Eliminar documento?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">No hay documentos.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">{{ $documentos->links() }}</div>
@endsection
