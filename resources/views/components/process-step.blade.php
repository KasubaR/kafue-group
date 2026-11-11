@props(['number', 'title'])
<div {{ $attributes->class(['step']) }}>
    <div class="num">{{ sprintf('%02d', $number) }}</div>
    <h3>{{ $title }}</h3>
    <p>{{ $slot }}</p>
</div>
