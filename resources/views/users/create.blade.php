<x-app-layout>
    <div class="min-h-[calc(100vh-4rem)] bg-slate-50 p-4 dark:bg-slate-950 lg:p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">Crear usuario</h1>
            <p class="text-sm text-slate-500">Registra una nueva cuenta y asigna sus permisos.</p>
        </div>

        <form method="POST" action="{{ route('users.store') }}">
            @include('users._form')
        </form>
    </div>
</x-app-layout>
