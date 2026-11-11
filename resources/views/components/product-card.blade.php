@props([
    'title',
    'image',          // path under public/, e.g. images/products/steel.jpg
    'icon' => '',     // inner SVG markup for the 24x24 icon
    'category' => '', // category pre-selected in the quote form when "Request a quote" is clicked
])
<article {{ $attributes->class(['card']) }}>
    <div class="card-img"><img src="{{ asset($image) }}" alt="" loading="lazy"></div>
    <div class="card-body">
        <div class="icon"><x-icon name="custom">{!! $icon !!}</x-icon></div>
        <h3>{{ $title }}</h3>
        <p>{{ $slot }}</p>
        <a class="card-link" href="{{ route('contact', array_filter(['category' => $category])) }}#quote">Request a quote <span aria-hidden="true">→</span></a>
    </div>
</article>
