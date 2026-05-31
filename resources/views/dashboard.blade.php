<x-app-layout>
    <div class="min-h-[calc(100vh-4rem)] bg-slate-50 p-6 dark:bg-slate-950">
        <div class="mx-auto max-w-3xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <h1 class="text-xl font-semibold text-slate-900 dark:text-slate-100">Dashboard</h1>
            <p class="mt-2 text-sm text-slate-500">El panel principal ahora es el explorador documental.</p>
            <a href="{{ route('explorer.index') }}" class="mt-4 inline-flex rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">Abrir explorador</a>
        </div>
    </div>
</x-app-layout>
