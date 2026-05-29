@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Carpetas</h1>
        @can('carpetas.crear')
            <a href="{{ route('carpetas.create') }}" class="btn btn-primary">Nueva carpeta</a>
        @endcan
    </div>
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead><tr><th>Nombre</th><th>Semestre</th><th>Padre</th><th>Subcarpetas</th><th>Documentos</th><th></th></tr></thead>
                <tbody>
                    @forelse ($carpetas as $carpeta)
                        <tr>
                            <td>{{ $carpeta->nombre }}</td>
                            <td>{{ $carpeta->semestre->nombre }} {{ $carpeta->semestre->anio }}</td>
                            <td>{{ $carpeta->padre?->nombre ?? 'Raiz' }}</td>
                            <td>{{ $carpeta->subcarpetas_count }}</td>
                            <td>{{ $carpeta->documentos_count }}</td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-outline-primary" href="{{ route('carpetas.show', $carpeta) }}">Ver</a>
                                @can('carpetas.editar') <a class="btn btn-sm btn-outline-secondary" href="{{ route('carpetas.edit', $carpeta) }}">Editar</a> @endcan
                                @can('carpetas.eliminar')
                                    <form method="POST" action="{{ route('carpetas.destroy', $carpeta) }}" class="d-inline" onsubmit="return confirm('Eliminar carpeta?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">No hay carpetas registradas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">{{ $carpetas->links() }}</div>
@endsection
