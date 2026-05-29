@extends('layouts.admin')

@section('content')
    <h1 class="h3 mb-4">Editar carpeta</h1>
    <div class="card border-0 shadow-sm"><div class="card-body">
        <form method="POST" action="{{ route('carpetas.update', $carpeta) }}">
            @method('PUT')
            @include('carpetas._form')
        </form>
    </div></div>
@endsection
