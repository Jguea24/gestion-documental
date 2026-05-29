@extends('layouts.admin')

@section('content')
    <h1 class="h3 mb-4">Editar semestre</h1>
    <div class="card border-0 shadow-sm"><div class="card-body">
        <form method="POST" action="{{ route('semestres.update', $semestre) }}">
            @method('PUT')
            @include('semestres._form')
        </form>
    </div></div>
@endsection
