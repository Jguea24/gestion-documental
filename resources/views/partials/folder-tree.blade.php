<ul class="list-unstyled ms-3 mb-0">
    @foreach ($carpetas as $node)
        <li class="mb-2">
            <a href="{{ route('carpetas.show', $node) }}" class="text-decoration-none">[Carpeta] {{ $node->nombre }}</a>
            @if ($node->subcarpetas->isNotEmpty())
                @include('partials.folder-tree', ['carpetas' => $node->subcarpetas])
            @endif
        </li>
    @endforeach
</ul>
