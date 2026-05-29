<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Gestion Documental') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f6f8fb; }
        .sidebar { min-height: calc(100vh - 56px); background: #1f2937; }
        .sidebar a { color: #d1d5db; text-decoration: none; }
        .sidebar a.active, .sidebar a:hover { color: #fff; background: #374151; }
        .stat-card { border: 0; border-left: 4px solid #2563eb; }
        .table td, .table th { vertical-align: middle; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand fw-semibold" href="{{ route('dashboard') }}">Gestion Documental</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="topNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item text-white-50 me-lg-3">{{ auth()->user()->name }}</li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-outline-light btn-sm" type="submit">Salir</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <aside class="col-lg-2 sidebar p-3">
                <nav class="nav flex-column gap-1">
                    <a class="nav-link rounded {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                    <a class="nav-link rounded {{ request()->routeIs('semestres.*') ? 'active' : '' }}" href="{{ route('semestres.index') }}">Semestres</a>
                    <a class="nav-link rounded {{ request()->routeIs('carpetas.*') ? 'active' : '' }}" href="{{ route('carpetas.index') }}">Carpetas</a>
                    <a class="nav-link rounded {{ request()->routeIs('documentos.*') ? 'active' : '' }}" href="{{ route('documentos.index') }}">Documentos</a>
                    <a class="nav-link rounded" href="{{ route('profile.edit') }}">Perfil</a>
                </nav>
            </aside>

            <main class="col-lg-10 p-4">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Revisa los campos del formulario.</strong>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
