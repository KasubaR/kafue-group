@php
    $a = config('site.address');
    $navLinks = collect(config('site.nav'))->map(fn ($i) => [route($i['route']), $i['label']])->all();
@endphp
<footer class="site-footer">
    <div class="container">
        <div>
            <x-logo />
            <p class="about">{{ config('site.tagline') }}</p>
            <p class="about small">{{ config('site.legal_name') }}<br>Reg. {{ config('site.registration') }}<br>{{ $a['street'] }}, {{ $a['city'] }}, {{ $a['region'] }}, {{ $a['postcode'] }}, {{ $a['country'] }}<br><a href="{{ config('site.phone_href') }}">{{ config('site.phone') }}</a></p>
        </div>
        <div class="footer-cols">
            <x-footer-links title="Pages" :links="$navLinks" />
            <x-footer-links title="Get in touch" :links="[
                [route('contact'), 'Request a quote'],
                [config('site.phone_href'), config('site.phone')],
            ]" />
        </div>
    </div>
</footer>
