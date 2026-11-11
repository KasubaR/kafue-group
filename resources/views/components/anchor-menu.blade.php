@props(['links' => []]) {{-- [[section id, label], ...] --}}
<nav {{ $attributes->class(['anchor-menu']) }} aria-label="On this page">
    <div class="container">
        @foreach ($links as [$id, $label])
            <a href="#{{ $id }}">{{ $label }}</a>
        @endforeach
    </div>
</nav>
