<x-layouts.admin title="Quote requests">
    <div class="admin-head">
        <h1>Quote requests</h1>
        <form method="GET" class="admin-search" role="search">
            <input type="hidden" name="show" value="{{ $show }}">
            <input type="search" name="q" value="{{ $search }}" placeholder="Search name, company, email, project" aria-label="Search quote requests">
            <button class="btn btn-dark" type="submit">Search</button>
        </form>
    </div>

    @if (session('status'))<div class="alert">{{ session('status') }}</div>@endif

    <nav class="admin-tabs" aria-label="Filter">
        <a href="{{ route('admin.quotes.index', ['show' => 'new', 'q' => $search ?: null]) }}" @class(['on' => $show === 'new'])>New <span>{{ $newCount }}</span></a>
        <a href="{{ route('admin.quotes.index', ['show' => 'handled', 'q' => $search ?: null]) }}" @class(['on' => $show === 'handled'])>Handled <span>{{ $handledCount }}</span></a>
        <a href="{{ route('admin.quotes.index', ['show' => 'all', 'q' => $search ?: null]) }}" @class(['on' => $show === 'all'])>All <span>{{ $newCount + $handledCount }}</span></a>
    </nav>

    @if ($quotes->isEmpty())
        <p class="empty">{{ $search !== '' ? 'No requests match that search.' : 'Nothing here yet.' }}</p>
    @else
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr><th>Received</th><th>Name</th><th>Category</th><th>Project</th><th>Status</th><th><span class="sr-only">Actions</span></th></tr>
                </thead>
                <tbody>
                    @foreach ($quotes as $quote)
                        <tr>
                            <td class="c-received" data-label="Received">{{ $quote->created_at->format('j M Y, H:i') }}</td>
                            <td class="c-name">
                                <strong>{{ $quote->name }}</strong>
                                <small>{{ $quote->company }}</small>
                            </td>
                            <td class="c-cat" data-label="Category">{{ $quote->category }}</td>
                            <td class="c-proj" data-label="Project">
                                {{ $quote->project ?: '—' }}
                                @if ($quote->attachment_path)<small>Has attachment</small>@endif
                            </td>
                            <td class="c-status">
                                <span @class(['pill', 'done' => $quote->handled_at])>{{ $quote->handled_at ? 'Handled' : 'New' }}</span>
                            </td>
                            <td class="col-action">
                                <a class="btn btn-outline btn-sm" href="{{ route('admin.quotes.show', $quote) }}" aria-label="View request from {{ $quote->name }}">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="admin-pager">
            @if ($quotes->previousPageUrl())<a href="{{ $quotes->previousPageUrl() }}">&larr; Newer</a>@else<span></span>@endif
            @if ($quotes->nextPageUrl())<a href="{{ $quotes->nextPageUrl() }}">Older &rarr;</a>@endif
        </div>
    @endif
</x-layouts.admin>
