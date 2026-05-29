@extends('layouts.admin')

@section('content')
    <h1 class="h3 mb-4">Subir documento</h1>
    <div class="card border-0 shadow-sm"><div class="card-body">
        <form method="POST" action="{{ route('documentos.store') }}" enctype="multipart/form-data">
            @include('documentos._form')
        </form>
    </div></div>
@endsection
