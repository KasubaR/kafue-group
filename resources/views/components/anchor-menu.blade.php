@props(['links' => []]) {{-- [[section id, label], ...] --}}
{{-- Chips that jump to sections of the page. Sits on the cream page background, under the banner. --}}
<nav {{ $attributes->class(['anchor-menu']) }} aria-label="On this page">
    <div class="container">
        @foreach ($links as [$id, $label])
            <a href="#{{ $id }}">{{ $label }}</a>
        @endforeach
    </div>
</nav>
