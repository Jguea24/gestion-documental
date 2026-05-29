@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Semestres</h1>
        @can('semestres.crear')
            <a href="{{ route('semestres.create') }}" class="btn btn-primary">Nuevo semestre</a>
        @endcan
    </div>
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead><tr><th>Nombre</th><th>Anio</th><th>Estado</th><th>Carpetas</th><th>Documentos</th><th></th></tr></thead>
                <tbody>
                    @forelse ($semestres as $semestre)
                        <tr>
                            <td>{{ $semestre->nombre }}</td>
                            <td>{{ $semestre->anio }}</td>
                            <td><span class="badge {{ $semestre->activo ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $semestre->activo ? 'Activo' : 'Inactivo' }}</span></td>
                            <td>{{ $semestre->carpetas_count }}</td>
                            <td>{{ $semestre->documentos_count }}</td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-outline-primary" href="{{ route('semestres.show', $semestre) }}">Ver</a>
                                @can('semestres.editar') <a class="btn btn-sm btn-outline-secondary" href="{{ route('semestres.edit', $semestre) }}">Editar</a> @endcan
                                @can('semestres.eliminar')
                                    <form method="POST" action="{{ route('semestres.destroy', $semestre) }}" class="d-inline" onsubmit="return confirm('Eliminar semestre?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">No hay semestres registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">{{ $semestres->links() }}</div>
@endsection
