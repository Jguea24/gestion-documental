@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">{{ $documento->nombre }}</h1>
        <a href="{{ route('documentos.index') }}" class="btn btn-outline-secondary">Volver</a>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Descripcion</dt><dd class="col-sm-9">{{ $documento->descripcion ?: 'Sin descripcion' }}</dd>
                <dt class="col-sm-3">Semestre</dt><dd class="col-sm-9">{{ $documento->semestre->nombre }} {{ $documento->semestre->anio }}</dd>
                <dt class="col-sm-3">Carpeta</dt><dd class="col-sm-9">{{ $documento->carpeta->nombre }}</dd>
                <dt class="col-sm-3">Usuario</dt><dd class="col-sm-9">{{ $documento->usuario->name }}</dd>
                <dt class="col-sm-3">Tipo</dt><dd class="col-sm-9 text-uppercase">{{ $documento->extension }}</dd>
                <dt class="col-sm-3">Tamano</dt><dd class="col-sm-9">{{ number_format($documento->tamano / 1024, 2) }} KB</dd>
                <dt class="col-sm-3">Fecha de carga</dt><dd class="col-sm-9">{{ $documento->fecha_subida->format('d/m/Y H:i') }}</dd>
            </dl>
            <div class="mt-4 d-flex gap-2">
                @can('documentos.descargar')
                    <a class="btn btn-primary" href="{{ route('documentos.download', $documento) }}">Descargar</a>
                @endcan
                @if ($documento->extension === 'pdf')
                    <a class="btn btn-outline-primary" href="{{ route('documentos.preview', $documento) }}">Vista previa PDF</a>
                @endif
                @can('documentos.editar')
                    <a class="btn btn-outline-secondary" href="{{ route('documentos.edit', $documento) }}">Editar</a>
                @endcan
            </div>
        </div>
    </div>
@endsection
