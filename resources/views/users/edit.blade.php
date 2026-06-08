<x-app-layout>
    <div class="min-h-[calc(100vh-4rem)] bg-slate-50 p-4 dark:bg-slate-950 lg:p-6">
        <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">Editar usuario</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">Actualiza credenciales, roles y permisos directos.</p>
            </div>

            <a href="{{ route('users.index') }}" class="inline-flex justify-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800">
                Volver
            </a>
        </div>

        <form method="POST" action="{{ route('users.update', $user) }}">
            @method('PUT')
            @include('users._form')
        </form>
    </div>
</x-app-layout>
