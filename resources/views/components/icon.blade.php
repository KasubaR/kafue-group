@props(['name'])
@php
    $paths = [
        'phone' => '<path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2z"/>',
        'check' => '<path d="m5 12.5 4.5 4.5L19 7.5"/>',
    ];
@endphp
<svg viewBox="0 0 24 24" aria-hidden="true" {{ $attributes }}>{!! $paths[$name] ?? $slot !!}</svg>
