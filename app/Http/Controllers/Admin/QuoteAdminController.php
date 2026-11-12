<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuoteRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class QuoteAdminController extends Controller
{
    public function index(Request $request): View
    {
        $show = in_array($request->query('show'), ['new', 'handled', 'all'], true) ? $request->query('show') : 'new';
        $search = trim((string) $request->query('q', ''));

        $quotes = QuoteRequest::query()
            ->when($show === 'new', fn ($q) => $q->whereNull('handled_at'))
            ->when($show === 'handled', fn ($q) => $q->whereNotNull('handled_at'))
            ->when($search !== '', function ($q) use ($search) {
                $like = '%'.str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $search).'%';
                $q->where(fn ($w) => $w->where('name', 'like', $like)
                    ->orWhere('company', 'like', $like)
                    ->orWhere('email', 'like', $like)
                    ->orWhere('project', 'like', $like)
                    ->orWhere('details', 'like', $like));
            })
            ->latest()
            ->simplePaginate(20)
            ->withQueryString();

        return view('admin.quotes.index', [
            'quotes' => $quotes,
            'show' => $show,
            'search' => $search,
            'newCount' => QuoteRequest::whereNull('handled_at')->count(),
            'handledCount' => QuoteRequest::whereNotNull('handled_at')->count(),
        ]);
    }

    public function show(QuoteRequest $quote): View
    {
        return view('admin.quotes.show', ['quote' => $quote]);
    }

    public function toggleHandled(QuoteRequest $quote): RedirectResponse
    {
        $quote->update(['handled_at' => $quote->handled_at ? null : now()]);

        return back()->with('status', $quote->handled_at ? 'Marked as handled.' : 'Moved back to new.');
    }

    public function attachment(QuoteRequest $quote): StreamedResponse
    {
        abort_unless($quote->attachment_path && Storage::exists($quote->attachment_path), 404);

        return Storage::download($quote->attachment_path, $quote->attachment_name);
    }
}
