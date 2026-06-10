<x-app-layout>
    <div x-data="fileExplorer()" x-init="init()" :class="{ 'dark': dark }" class="min-h-[calc(100vh-4rem)]">
        <div class="flex bg-slate-100 text-slate-900 dark:bg-slate-950 dark:text-slate-100">
            <aside class="hidden w-80 shrink-0 border-r border-slate-200 bg-white p-5 dark:border-slate-800 dark:bg-slate-900 lg:block">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-xs font-bold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Carpetas</h2>
                    <button type="button" @click="dark = !dark; localStorage.setItem('darkMode', dark ? '1' : '0')" class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
                        Modo
                    </button>
                </div>
                @include('explorer.partials.tree', ['folders' => $sidebarFolders, 'breadcrumbs' => $breadcrumbs])
            </aside>

            <main class="min-w-0 flex-1 p-4 lg:p-6">
                @if ($errors->any())
                    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 dark:border-red-900 dark:bg-red-950 dark:text-red-200">
                        Revisa los datos ingresados.
                    </div>
                @endif

                <section class="mb-5 rounded-3xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
                        <div class="min-w-0">
                            <div class="mb-2 flex flex-wrap items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
                                <a href="{{ route('explorer.index') }}" class="hover:text-blue-600">Inicio</a>
                                @foreach ($breadcrumbs as $crumb)
                                    <span>/</span>
                                    <a href="{{ route('explorer.index', ['folder' => $crumb->id]) }}" class="hover:text-blue-600">{{ $crumb->name }}</a>
                                @endforeach
                            </div>
                            <h1 class="truncate text-2xl font-semibold">{{ $currentFolder?->name ?? 'Explorador' }}</h1>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            @can('folders.create')
                                <button type="button" @click="$dispatch('open-modal', 'create-folder-modal')" class="rounded-xl bg-emerald-800 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-900">Nueva carpeta</button>
                            @endcan
                            @can('documents.upload')
                                <button type="button" @click="$dispatch('open-modal', 'upload-document-modal')" class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-slate-700 dark:bg-white dark:text-slate-900">Subir archivos</button>
                            @endcan
                        </div>
                    </div>

                    <form method="GET" action="{{ route('explorer.index') }}" class="mt-4 grid gap-3 md:grid-cols-5">
                        <input type="hidden" name="folder" value="{{ $currentFolder?->id }}">
                        <input name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Buscar carpetas o archivos" class="rounded-lg border-slate-300 text-sm dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100">
                        <input name="semester" value="{{ $filters['semester'] ?? '' }}" placeholder="Semestre" class="rounded-lg border-slate-300 text-sm dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100">
                        <input name="subject" value="{{ $filters['subject'] ?? '' }}" placeholder="Materia" class="rounded-lg border-slate-300 text-sm dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100">
                        <select name="user_id" class="rounded-lg border-slate-300 text-sm dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100">
                            <option value="">Todos los usuarios</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" @selected(($filters['user_id'] ?? '') == $user->id)>{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <button class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold hover:bg-slate-100 dark:border-slate-700 dark:hover:bg-slate-800">Buscar</button>
                    </form>
                </section>

                <section
                    @dragover.prevent="dragging = true"
                    @dragleave.prevent="dragging = false"
                    @drop.prevent="dragging = false; $refs.dropFiles.files = $event.dataTransfer.files; $refs.dropForm.submit()"
                    :class="{ 'ring-2 ring-blue-500 bg-blue-50 dark:bg-blue-950': dragging }"
                    class="min-h-[28rem] rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition dark:border-slate-800 dark:bg-slate-900">
                    <form x-ref="dropForm" method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data" class="hidden">
                        @csrf
                        <input type="hidden" name="folder_id" value="{{ $currentFolder?->id }}">
                        <input x-ref="dropFiles" type="file" name="files[]" multiple>
                    </form>

                    <div class="mb-3 flex items-center justify-between">
                        <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Contenido</h2>
                        <p class="text-xs text-slate-400">Arrastra archivos aqui para subirlos</p>
                    </div>

                    <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-5 2xl:grid-cols-7">
                        @foreach ($folders as $folder)
                            <div @contextmenu.prevent="openFolderMenu($event, {{ $folder->id }}, @js($folder->name))" class="group relative rounded-2xl border border-transparent p-4 transition hover:-translate-y-0.5 hover:border-emerald-100 hover:bg-emerald-50/60 hover:shadow-md dark:hover:border-emerald-900 dark:hover:bg-slate-800">
                                <button
                                    type="button"
                                    @click.stop="openActionMenu($event, 'folder', {{ $folder->id }}, @js($folder->name))"
                                    class="absolute right-2 top-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white/90 text-slate-500 opacity-0 shadow-sm ring-1 ring-slate-200 hover:text-emerald-800 group-hover:opacity-100 dark:bg-slate-900/90 dark:ring-slate-700 dark:hover:text-white"
                                    aria-label="Opciones de carpeta"
                                >
                                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 6.5a1.5 1.5 0 110-3 1.5 1.5 0 010 3zM10 11.5a1.5 1.5 0 110-3 1.5 1.5 0 010 3zM10 16.5a1.5 1.5 0 110-3 1.5 1.5 0 010 3z" />
                                    </svg>
                                </button>
                                <a href="{{ route('explorer.index', ['folder' => $folder->id]) }}" class="block">
                                    <div class="mx-auto mb-3 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-amber-100 to-yellow-50 text-amber-600 shadow-inner dark:bg-amber-950">
                                        <svg class="h-10 w-10" viewBox="0 0 24 24" fill="currentColor"><path d="M10 4l2 2h8a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2h6z"/></svg>
                                    </div>
                                    <div class="truncate text-center text-sm font-medium">{{ $folder->name }}</div>
                                    <div class="text-center text-xs text-slate-400">{{ $folder->children_count }} carpetas, {{ $folder->documents_count }} archivos</div>
                                </a>
                            </div>
                        @endforeach

                        @foreach ($documents as $document)
                            <div @contextmenu.prevent="openDocumentMenu($event, {{ $document->id }}, @js($document->original_name))" class="group relative rounded-xl border border-transparent p-3 hover:border-blue-200 hover:bg-blue-50 dark:hover:border-blue-900 dark:hover:bg-slate-800">
                                <button
                                    type="button"
                                    @click.stop="openActionMenu($event, 'document', {{ $document->id }}, @js($document->original_name))"
                                    class="absolute right-2 top-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white/90 text-slate-500 opacity-0 shadow-sm ring-1 ring-slate-200 hover:text-slate-900 group-hover:opacity-100 dark:bg-slate-900/90 dark:ring-slate-700 dark:hover:text-white"
                                    aria-label="Opciones de archivo"
                                >
                                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 6.5a1.5 1.5 0 110-3 1.5 1.5 0 010 3zM10 11.5a1.5 1.5 0 110-3 1.5 1.5 0 010 3zM10 16.5a1.5 1.5 0 110-3 1.5 1.5 0 010 3z" />
                                    </svg>
                                </button>
                                <a href="{{ $document->isPreviewable() ? route('documents.preview', $document) : route('documents.download', $document) }}" class="block">
                                    <div class="mx-auto mb-3 flex h-16 w-16 items-center justify-center rounded-xl {{ $document->isPdf() ? 'bg-red-100 text-red-600 dark:bg-red-950' : ($document->isImage() ? 'bg-emerald-100 text-emerald-600 dark:bg-emerald-950' : 'bg-slate-100 text-slate-600 dark:bg-slate-800') }}">
                                        <span class="text-sm font-bold uppercase">{{ $document->extension }}</span>
                                    </div>
                                    <div class="truncate text-center text-sm font-medium">{{ $document->original_name }}</div>
                                    <div class="text-center text-xs text-slate-400">
                                        {{ $document->isPreviewable() ? 'Abrir' : 'Descargar' }} / {{ number_format($document->size / 1024, 1) }} KB
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    @if ($folders->isEmpty() && $documents->isEmpty())
                        <div class="flex h-72 items-center justify-center text-center text-slate-400">
                            <div>
                                <div class="mb-2 text-lg font-semibold">Carpeta vacia</div>
                                <p class="text-sm">Crea una carpeta o arrastra archivos a esta zona.</p>
                            </div>
                        </div>
                    @endif
                </section>
            </main>
        </div>

        <div x-show="context.open" x-cloak @click.outside="context.open = false" :style="`left:${context.x}px; top:${context.y}px`" class="fixed z-50 w-56 rounded-xl border border-slate-200 bg-white p-2 shadow-xl dark:border-slate-700 dark:bg-slate-900">
            <button type="button" @click="$dispatch('open-modal', 'rename-resource-modal'); context.open = false" class="block w-full rounded-lg px-3 py-2 text-left text-sm hover:bg-slate-100 dark:hover:bg-slate-800">Editar nombre</button>
            <button type="button" @click="$dispatch('open-modal', 'move-resource-modal'); context.open = false" class="block w-full rounded-lg px-3 py-2 text-left text-sm hover:bg-slate-100 dark:hover:bg-slate-800">Mover</button>
            <a x-show="context.type === 'document'" :href="`/documents/${context.id}/download`" class="block rounded-lg px-3 py-2 text-sm hover:bg-slate-100 dark:hover:bg-slate-800">Descargar</a>
            <form :action="context.type === 'folder' ? `/folders/${context.id}` : `/documents/${context.id}`" method="POST" @submit="if (!confirmSubmit($el, context.type === 'folder' ? 'Eliminar carpeta' : 'Eliminar archivo', 'Esta accion enviara el elemento a la papelera.')) $event.preventDefault()">
                @csrf
                @method('DELETE')
                <button class="block w-full rounded-lg px-3 py-2 text-left text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-950">Eliminar</button>
            </form>
        </div>

        <x-modal name="create-folder-modal" maxWidth="md">
            <form method="POST" action="{{ route('folders.store') }}" class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl dark:bg-slate-900">
                @csrf
                <input type="hidden" name="parent_id" value="{{ $currentFolder?->id }}">
                <h3 class="mb-4 text-lg font-semibold">Nueva carpeta</h3>
                <input name="name" class="w-full rounded-lg border-slate-300 dark:border-slate-700 dark:bg-slate-950" placeholder="Nombre de carpeta" required>
                <textarea name="description" class="mt-3 w-full rounded-lg border-slate-300 dark:border-slate-700 dark:bg-slate-950" rows="3" placeholder="Descripcion"></textarea>
                <div class="mt-5 flex justify-end gap-2">
                    <button type="button" @click="$dispatch('close-modal', 'create-folder-modal')" class="rounded-lg px-4 py-2 text-sm">Cancelar</button>
                    <button class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white">Crear</button>
                </div>
            </form>
        </x-modal>

        <x-modal name="upload-document-modal" maxWidth="md">
            <form method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data" class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl dark:bg-slate-900">
                @csrf
                <input type="hidden" name="folder_id" value="{{ $currentFolder?->id }}">
                <h3 class="mb-4 text-lg font-semibold">Subir archivos</h3>
                <input type="file" name="files[]" multiple class="w-full rounded-lg border-slate-300 dark:border-slate-700 dark:bg-slate-950" required>
                <div class="mt-5 flex justify-end gap-2">
                    <button type="button" @click="$dispatch('close-modal', 'upload-document-modal')" class="rounded-lg px-4 py-2 text-sm">Cancelar</button>
                    <button class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white">Subir</button>
                </div>
            </form>
        </x-modal>

        <x-modal name="rename-resource-modal" maxWidth="md">
            <form :action="context.type === 'folder' ? `/folders/${context.id}` : `/documents/${context.id}`" method="POST" class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl dark:bg-slate-900">
                @csrf
                @method('PATCH')
                <h3 class="mb-4 text-lg font-semibold">Renombrar</h3>
                <input :name="context.type === 'folder' ? 'name' : 'original_name'" x-model="context.name" class="w-full rounded-lg border-slate-300 dark:border-slate-700 dark:bg-slate-950" required>
                <div class="mt-5 flex justify-end gap-2">
                    <button type="button" @click="$dispatch('close-modal', 'rename-resource-modal')" class="rounded-lg px-4 py-2 text-sm">Cancelar</button>
                    <button class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white">Guardar</button>
                </div>
            </form>
        </x-modal>

        <x-modal name="move-resource-modal" maxWidth="md">
            <form :action="context.type === 'folder' ? `/folders/${context.id}/move` : `/documents/${context.id}/move`" method="POST" class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl dark:bg-slate-900">
                @csrf
                @method('PATCH')
                <h3 class="mb-4 text-lg font-semibold">Mover</h3>
                <select :name="context.type === 'folder' ? 'parent_id' : 'folder_id'" class="w-full rounded-lg border-slate-300 dark:border-slate-700 dark:bg-slate-950">
                    <option value="">Raiz</option>
                    @foreach ($allFolders as $folder)
                        <option value="{{ $folder->id }}">{{ $folder->name }}</option>
                    @endforeach
                </select>
                <div class="mt-5 flex justify-end gap-2">
                    <button type="button" @click="$dispatch('close-modal', 'move-resource-modal')" class="rounded-lg px-4 py-2 text-sm">Cancelar</button>
                    <button class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white">Mover</button>
                </div>
            </form>
        </x-modal>
    </div>

    <script>
        function fileExplorer() {
            return {
                dark: false,
                dragging: false,
                context: { open: false, x: 0, y: 0, id: null, name: '', type: null },
                init() { this.dark = localStorage.getItem('darkMode') === '1'; },
                openActionMenu(event, type, id, name) {
                    this.context = {
                        open: true,
                        x: Math.min(event.clientX, window.innerWidth - 240),
                        y: Math.min(event.clientY, window.innerHeight - 220),
                        id,
                        name,
                        type,
                    };
                },
                openFolderMenu(event, id, name) { this.openActionMenu(event, 'folder', id, name); },
                openDocumentMenu(event, id, name) { this.openActionMenu(event, 'document', id, name); },
            }
        }
    </script>
</x-app-layout>
