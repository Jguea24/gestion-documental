<x-app-layout>
    <div class="min-h-[calc(100vh-4rem)] bg-slate-50 p-4 dark:bg-slate-950 lg:p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">Papelera</h1>
            <p class="text-sm text-slate-500">Restaura carpetas y archivos eliminados.</p>
        </div>

        @if (session('success'))
            <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 dark:border-emerald-900 dark:bg-emerald-950 dark:text-emerald-200">{{ session('success') }}</div>
        @endif

        <div class="grid gap-6 lg:grid-cols-2">
            <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <h2 class="mb-3 font-semibold text-slate-900 dark:text-slate-100">Carpetas eliminadas</h2>
                <div class="space-y-2">
                    @forelse ($folders as $folder)
                        <div class="flex items-center justify-between rounded-xl border border-slate-200 p-3 dark:border-slate-800">
                            <div>
                                <div class="font-medium text-slate-900 dark:text-slate-100">{{ $folder->name }}</div>
                                <div class="text-xs text-slate-500">Eliminada: {{ $folder->deleted_at?->format('d/m/Y H:i') }}</div>
                            </div>
                            <div class="flex gap-2">
                                <form method="POST" action="{{ route('folders.restore', $folder->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm font-semibold hover:bg-slate-50 dark:border-slate-700 dark:hover:bg-slate-800">Restaurar</button>
                                </form>
                                <form method="POST" action="{{ route('folders.force-delete', $folder->id) }}" onsubmit="return confirm('Eliminar definitivamente esta carpeta? Esta accion no se puede deshacer.')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="rounded-lg border border-red-200 px-3 py-1.5 text-sm font-semibold text-red-600 hover:bg-red-50 dark:border-red-900 dark:hover:bg-red-950">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">No hay carpetas eliminadas.</p>
                    @endforelse
                </div>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <h2 class="mb-3 font-semibold text-slate-900 dark:text-slate-100">Archivos eliminados</h2>
                <div class="space-y-2">
                    @forelse ($documents as $document)
                        <div class="flex items-center justify-between rounded-xl border border-slate-200 p-3 dark:border-slate-800">
                            <div>
                                <div class="font-medium text-slate-900 dark:text-slate-100">{{ $document->original_name }}.{{ $document->extension }}</div>
                                <div class="text-xs text-slate-500">Eliminado: {{ $document->deleted_at?->format('d/m/Y H:i') }}</div>
                            </div>
                            <div class="flex gap-2">
                                <form method="POST" action="{{ route('documents.restore', $document->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm font-semibold hover:bg-slate-50 dark:border-slate-700 dark:hover:bg-slate-800">Restaurar</button>
                                </form>
                                <form method="POST" action="{{ route('documents.force-delete', $document->id) }}" onsubmit="return confirm('Eliminar definitivamente este archivo? Esta accion no se puede deshacer.')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="rounded-lg border border-red-200 px-3 py-1.5 text-sm font-semibold text-red-600 hover:bg-red-50 dark:border-red-900 dark:hover:bg-red-950">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">No hay archivos eliminados.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
