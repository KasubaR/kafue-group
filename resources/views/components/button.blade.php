@props([
    'href' => null,
    'variant' => 'primary', // primary | dark (black, on teal bands) | outline (light backgrounds) | ghost (dark backgrounds)
    'type' => 'button',
])
@php $classes = 'btn btn-'.$variant; @endphp
@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</button>
@endif
