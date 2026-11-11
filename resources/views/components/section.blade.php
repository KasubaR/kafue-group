@props([
    'id' => null,
    'tone' => 'sand', // sand | white
])
<section @if ($id) id="{{ $id }}" @endif {{ $attributes->class(['section', $tone]) }}>
    <div class="container">
        {{ $slot }}
    </div>
</section>
