@props(['title', 'buttonLabel', 'href'])
{{-- Dark highlight panel with one action. The default slot is the supporting text. --}}
<div {{ $attributes->class(['callout']) }}>
    <div>
        <h3>{{ $title }}</h3>
        <p>{{ $slot }}</p>
    </div>
    <x-button :href="$href">{{ $buttonLabel }}</x-button>
</div>
