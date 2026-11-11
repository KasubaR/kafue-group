@props(['items' => []]) {{-- [[label, value], ...] --}}
<dl {{ $attributes->class(['detail-list']) }}>
    @foreach ($items as [$label, $value])
        <div><dt>{{ $label }}</dt><dd>{{ $value }}</dd></div>
    @endforeach
</dl>
