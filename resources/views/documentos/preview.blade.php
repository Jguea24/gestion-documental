@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Vista previa: {{ $documento->nombre }}</h1>
        <a href="{{ route('documentos.show', $documento) }}" class="btn btn-outline-secondary">Volver</a>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <iframe src="{{ Storage::disk('public')->url($documento->archivo) }}" class="w-100 border rounded" style="height: 75vh;"></iframe>
        </div>
    </div>
@endsection
