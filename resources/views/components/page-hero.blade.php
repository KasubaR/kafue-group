@props(['eyebrow' => null, 'title', 'crumb' => null])
{{--
    Banner for inner pages, with a breadcrumb back to Home. The default slot is the intro paragraph.
    The crumb label defaults to the page's name in the main nav (config/site.php), then to the eyebrow.
--}}
@php
    $navLabel = collect(config('site.nav'))->firstWhere('route', request()->route()?->getName())['label'] ?? null;
    $crumbLabel = $crumb ?? $navLabel ?? $eyebrow ?? $title;
@endphp
<section {{ $attributes->class(['page-hero']) }}>
    <div class="container">
        <x-breadcrumbs :current="$crumbLabel" />
        @if ($eyebrow)<x-eyebrow light>{{ $eyebrow }}</x-eyebrow>@endif
        <h1>{{ $title }}</h1>
        @if (trim((string) $slot) !== '')<p class="lead">{{ $slot }}</p>@endif
    </div>
</section>
