@props(['title' => 'Admin', 'bare' => false])
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $title }} | {{ config('site.name') }} admin</title>
    {{-- Tab icon: the Africa map, same set as the public site (keep the ?v= in step with layouts/app) --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}?v=2" sizes="any">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v=2">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32.png') }}?v=2">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pages/admin.css') }}">
</head>
<body class="admin">
@unless ($bare)
    <header class="admin-bar">
        <div class="admin-wrap">
            <a class="admin-brand" href="{{ route('admin.quotes.index') }}">
                <img src="{{ asset('images/logo-reversed.svg') }}" alt="{{ config('site.legal_name') }}">
                <span>Admin</span>
            </a>
            <nav class="admin-nav">
                <a href="{{ route('home') }}" target="_blank" rel="noopener">View site</a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit">Sign out</button>
                </form>
            </nav>
        </div>
    </header>
@endunless

<main class="admin-wrap">
    {{ $slot }}
</main>
</body>
</html>
