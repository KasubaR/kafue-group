@props(['title', 'buttonLabel', 'href' => null])
<div class="cta-wrap">
    <div class="container">
        <div {{ $attributes->class(['cta']) }}>
            <div>
                <h2>{{ $title }}</h2>
                <p>{{ $slot }}</p>
            </div>
            <x-button :href="$href ?? route('contact').'#quote'" variant="dark">{{ $buttonLabel }}</x-button>
        </div>
    </div>
</div>
