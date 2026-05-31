<ul class="space-y-1">
    @foreach ($folders as $folder)
        @php
            $hasChildren = $folder->recursiveChildren->isNotEmpty();
            $isInCurrentPath = isset($breadcrumbs) && $breadcrumbs->contains('id', $folder->id);
        @endphp

        <li x-data="{ open: @js($isInCurrentPath) }">
            <div class="group flex items-center rounded-xl text-sm text-slate-600 hover:bg-emerald-50 dark:text-slate-300 dark:hover:bg-slate-800">
                @if ($hasChildren)
                    <button
                        type="button"
                        @click="open = !open"
                        class="flex h-7 w-7 shrink-0 items-center justify-center rounded-md text-slate-400 hover:text-emerald-800 dark:hover:text-slate-100"
                        :aria-expanded="open.toString()"
                        aria-label="Abrir o cerrar carpeta"
                    >
                        <svg class="h-3.5 w-3.5 transition-transform" :class="{ 'rotate-90': open }" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M7 5l6 5-6 5V5z" />
                        </svg>
                    </button>
                @else
                    <span class="h-7 w-7 shrink-0"></span>
                @endif

                <a href="{{ route('explorer.index', ['folder' => $folder->id]) }}"
                   class="flex min-w-0 flex-1 items-center gap-2 rounded-lg py-1.5 pr-2">
                    <svg class="h-4 w-4 shrink-0 text-amber-500" viewBox="0 0 24 24" fill="currentColor"><path d="M10 4l2 2h8a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2h6z"/></svg>
                    <span class="truncate">{{ $folder->name }}</span>
                </a>

                <button
                    type="button"
                    @click.stop="openActionMenu($event, 'folder', {{ $folder->id }}, @js($folder->name))"
                    class="mr-1 flex h-7 w-7 shrink-0 items-center justify-center rounded-md text-slate-400 opacity-0 hover:bg-emerald-100 hover:text-emerald-800 group-hover:opacity-100 dark:hover:bg-slate-700 dark:hover:text-slate-100"
                    aria-label="Opciones de carpeta"
                >
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 6.5a1.5 1.5 0 110-3 1.5 1.5 0 010 3zM10 11.5a1.5 1.5 0 110-3 1.5 1.5 0 010 3zM10 16.5a1.5 1.5 0 110-3 1.5 1.5 0 010 3z" />
                    </svg>
                </button>
            </div>

            @if ($hasChildren)
                <div
                    x-show="open"
                    class="ml-4 border-l border-slate-200 pl-2 dark:border-slate-800"
                >
                    @include('explorer.partials.tree', ['folders' => $folder->recursiveChildren, 'breadcrumbs' => $breadcrumbs ?? collect()])
                </div>
            @endif
        </li>
    @endforeach
</ul>
