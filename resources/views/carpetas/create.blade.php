@extends('layouts.admin')

@section('content')
    <h1 class="h3 mb-4">Crear carpeta</h1>
    <div class="card border-0 shadow-sm"><div class="card-body">
        <form method="POST" action="{{ route('carpetas.store') }}">
            @include('carpetas._form')
        </form>
    </div></div>
@endsection
