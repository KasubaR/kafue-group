@props(['label' => null])
<blockquote {{ $attributes->class(['pullquote']) }}>
    @if ($label)<x-eyebrow light>{{ $label }}</x-eyebrow>@endif
    <p>{{ $slot }}</p>
</blockquote>
