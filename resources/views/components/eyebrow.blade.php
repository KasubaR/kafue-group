@props(['light' => false])
<div {{ $attributes->class(['eyebrow', 'light' => $light]) }}>{{ $slot }}</div>
