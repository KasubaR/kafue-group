@props([
    'title',
    'tag' => null,        // small label above the title
    'href' => null,       // optional link
    'linkLabel' => 'Request a quote',
])
<article {{ $attributes->class(['info-card']) }}>
    @if ($tag)<div class="tag">{{ $tag }}</div>@endif
    <h3>{{ $title }}</h3>
    <p>{{ $slot }}</p>
    @if ($href)<a class="info-link" href="{{ $href }}">{{ $linkLabel }} <span aria-hidden="true">→</span></a>@endif
</article>
