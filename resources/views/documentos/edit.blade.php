@extends('layouts.admin')

@section('content')
    <h1 class="h3 mb-4">Editar documento</h1>
    <div class="card border-0 shadow-sm"><div class="card-body">
        <form method="POST" action="{{ route('documentos.update', $documento) }}" enctype="multipart/form-data">
            @method('PUT')
            @include('documentos._form')
        </form>
    </div></div>
@endsection
