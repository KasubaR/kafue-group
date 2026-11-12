<x-layouts.admin :title="'Request from '.$quote->name">
    <p class="back"><a href="{{ route('admin.quotes.index') }}">&larr; All requests</a></p>

    @if (session('status'))<div class="alert">{{ session('status') }}</div>@endif

    <div class="admin-head">
        <div>
            <h1>{{ $quote->name }}</h1>
            <p class="muted">{{ $quote->company }} &middot; received {{ $quote->created_at->format('j M Y, H:i') }}</p>
        </div>
        <form method="POST" action="{{ route('admin.quotes.handled', $quote) }}">
            @csrf
            <button class="btn {{ $quote->handled_at ? 'btn-outline' : 'btn-primary' }}" type="submit">
                {{ $quote->handled_at ? 'Move back to new' : 'Mark as handled' }}
            </button>
        </form>
    </div>

    <div class="admin-card">
        <dl class="admin-dl">
            <div><dt>Status</dt><dd><span @class(['pill', 'done' => $quote->handled_at])>{{ $quote->handled_at ? 'Handled '.$quote->handled_at->format('j M Y, H:i') : 'New' }}</span></dd></div>
            <div><dt>Category</dt><dd>{{ $quote->category }}</dd></div>
            <div><dt>Email</dt><dd><a href="mailto:{{ $quote->email }}">{{ $quote->email }}</a></dd></div>
            <div><dt>Phone</dt><dd>@if ($quote->phone)<a href="tel:{{ preg_replace('/[^+\d]/', '', $quote->phone) }}">{{ $quote->phone }}</a>@else — @endif</dd></div>
            <div><dt>Project or site</dt><dd>{{ $quote->project ?: '—' }}</dd></div>
            @if ($quote->site_country)<div><dt>Site country</dt><dd>{{ $quote->site_country }}</dd></div>@endif
            @if ($quote->required_by)<div><dt>Required on site by</dt><dd>{{ $quote->required_by->format('j F Y') }}</dd></div>@endif
            <div><dt>Email notification</dt><dd>{{ $quote->emailed_at ? 'Sent '.$quote->emailed_at->format('j M Y, H:i') : 'Not sent' }}</dd></div>
        </dl>

        <h2>Details</h2>
        <div class="details">{{ $quote->details }}</div>

        @if ($quote->attachment_path)
            <h2>Attachment</h2>
            <a class="btn btn-dark" href="{{ route('admin.quotes.attachment', $quote) }}">Download {{ $quote->attachment_name }}</a>
        @endif
    </div>
</x-layouts.admin>
