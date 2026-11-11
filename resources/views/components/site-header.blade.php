<header class="site-header">
    <div class="container">
        <x-logo />

        <button class="nav-toggle" type="button" aria-label="Menu" aria-expanded="false" aria-controls="site-nav">
            <span></span><span></span><span></span>
        </button>

        <nav class="nav" id="site-nav" aria-label="Main">
            @foreach (config('site.nav') as $item)
                <a href="{{ route($item['route']) }}" @class(['active' => request()->routeIs($item['route'])]) @if (request()->routeIs($item['route'])) aria-current="page" @endif>{{ $item['label'] }}</a>
            @endforeach
            <a class="nav-phone" href="{{ config('site.phone_href') }}" aria-label="Call {{ config('site.phone') }}" title="{{ config('site.phone') }}">
                <x-icon name="phone" />
            </a>
            <x-button :href="route('contact')">Request a quote</x-button>
        </nav>
    </div>
</header>
