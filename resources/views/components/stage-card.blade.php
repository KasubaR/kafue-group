@props(['number', 'title'])
<article {{ $attributes->class(['stage']) }}>
    <div class="num">{{ sprintf('%02d', $number) }}</div>
    <h3>{{ $title }}</h3>
    <p>{{ $slot }}</p>
</article>
