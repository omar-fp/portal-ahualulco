@if ($paginator->hasPages())
    <nav class="paginacion" aria-label="Paginación">
        {{-- Anterior --}}
        @if ($paginator->onFirstPage())
            <span class="desactivado">&laquo; Anterior</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}">&laquo; Anterior</a>
        @endif

        {{-- Números de página --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="desactivado">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $pagina => $url)
                    @if ($pagina == $paginator->currentPage())
                        <span class="actual">{{ $pagina }}</span>
                    @else
                        <a href="{{ $url }}">{{ $pagina }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Siguiente --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}">Siguiente &raquo;</a>
        @else
            <span class="desactivado">Siguiente &raquo;</span>
        @endif
    </nav>
@endif
