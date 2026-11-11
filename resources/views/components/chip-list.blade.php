@props(['items' => []])
<ul {{ $attributes->class(['chips']) }}>
    @foreach ($items as $item)
        <li>{{ $item }}</li>
    @endforeach
</ul>
