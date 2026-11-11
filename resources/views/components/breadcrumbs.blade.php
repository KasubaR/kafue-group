@props(['current']) {{-- label of the page you are on; Home is always the first crumb --}}
<nav {{ $attributes->class(['breadcrumbs']) }} aria-label="Breadcrumb">
    <ol>
        <li><a href="{{ route('home') }}">Home</a></li>
        <li aria-current="page">{{ $current }}</li>
    </ol>
</nav>

{{-- Breadcrumb data for search engines --}}
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('home')],
        ['@type' => 'ListItem', 'position' => 2, 'name' => $current, 'item' => url()->current()],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
