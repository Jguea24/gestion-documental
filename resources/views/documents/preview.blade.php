<x-app-layout>
    <div class="min-h-[calc(100vh-4rem)] bg-slate-50 p-4 dark:bg-slate-950 lg:p-6">
        <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-xl font-semibold text-slate-900 dark:text-slate-100">{{ $document->original_name }}</h1>
                <p class="text-sm text-slate-500">{{ strtoupper($document->extension) }} / {{ number_format($document->size / 1024, 1) }} KB</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('explorer.index', ['folder' => $document->folder_id]) }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-white dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-900">Volver</a>
                <a href="{{ route('documents.download', $document) }}" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">Descargar</a>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            @if ($document->isPdf())
                <iframe src="{{ route('documents.inline', $document) }}" class="h-[75vh] w-full rounded-xl border border-slate-200 dark:border-slate-800"></iframe>
            @elseif ($document->isImage())
                <img src="{{ route('documents.inline', $document) }}" alt="{{ $document->original_name }}" class="mx-auto max-h-[75vh] rounded-xl object-contain">
            @else
                <div class="flex h-80 items-center justify-center text-center">
                    <div>
                        <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-2xl bg-slate-100 text-lg font-bold uppercase text-slate-600 dark:bg-slate-800 dark:text-slate-300">{{ $document->extension }}</div>
                        <p class="text-slate-600 dark:text-slate-300">
                            @if ($document->isOfficeDocument())
                                Los archivos Office como Word, Excel o PowerPoint no se pueden previsualizar directamente en el navegador.
                            @else
                                Este tipo de archivo no tiene vista previa disponible.
                            @endif
                        </p>
                        <a href="{{ route('documents.download', $document) }}" class="mt-5 inline-flex rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                            Descargar archivo
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
