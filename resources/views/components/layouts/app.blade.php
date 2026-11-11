@props([
    'title' => config('site.name').' | Industrial supply for mining and construction',
    'description' => config('site.description'),
])
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    {{-- Tab icon: the Africa map only. Bump ?v= when the icon changes (browsers cache favicons hard). --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}?v=2" sizes="any">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v=2">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32.png') }}?v=2">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Global styles (every page) --}}
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
    {{-- Page styles: @push('styles') from a page view --}}
    @stack('styles')

    <script>document.documentElement.classList.add('js');</script>
</head>
<body>

<x-site-header />

{{ $slot }}

<x-site-footer />

<a class="float-call" href="{{ config('site.phone_href') }}" aria-label="Call {{ config('site.name') }}">
    <x-icon name="phone" />
    Call us
</a>

{{-- Global scripts (every page) --}}
<script src="{{ asset('js/reveal.js') }}" defer></script>
<script src="{{ asset('js/menu.js') }}" defer></script>
<script src="{{ asset('js/form-controls.js') }}" defer></script>
{{-- Page scripts: @push('scripts') from a page view --}}
@stack('scripts')
</body>
</html>
