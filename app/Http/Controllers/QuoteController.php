<?php

namespace App\Http\Controllers;

use App\Mail\QuoteRequestReceived;
use App\Models\QuoteRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class QuoteController extends Controller
{
    public const CATEGORIES = [
        'Steel and plate',
        'Pumps and spares',
        'Pipes and valves',
        'Wear parts and liners',
        'Electrical and instrumentation',
        'Fasteners and hardware',
        'Welding and fabrication supplies',
        'Safety and PPE',
        'Lubricants and chemicals',
        'Tools and equipment',
        'Lifting equipment',
    ];

    private const SUCCESS = 'Thank you. Your request has been received and our team will be in touch.';

    public function store(Request $request): RedirectResponse
    {
        // Honeypot: real visitors never see or fill this field. Pretend success so bots learn nothing.
        if ($request->filled('website')) {
            return $this->done();
        }

        $attachments = config('site.attachments');

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'company' => ['nullable', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'phone' => ['nullable', 'string', 'max:40'],
            'project' => ['nullable', 'string', 'max:160'],
            'category' => ['required', 'in:'.implode(',', self::CATEGORIES)],
            'site_country' => ['nullable', 'string', 'max:80'],
            'required_by' => ['nullable', 'date', 'after_or_equal:today'],
            'details' => ['required', 'string', 'max:5000'],
            'attachment' => ['nullable', 'file', 'mimes:'.implode(',', $attachments['types']), 'max:'.$attachments['max_kb']],
        ], [
            'attachment.mimes' => 'Attach a PDF, spreadsheet, document or image (PDF, XLS, XLSX, CSV, DOC, DOCX, PNG, JPG).',
            'attachment.max' => 'The file is too large. Please keep it under '.($attachments['max_kb'] / 1024).' MB or email it to us instead.',
            'required_by.after_or_equal' => 'The required date cannot be in the past.',
        ]);

        $file = $request->file('attachment');

        $quote = QuoteRequest::create([
            ...collect($data)->except('attachment')->all(),
            'attachment_path' => $file?->store('quote-attachments'),
            'attachment_name' => $file?->getClientOriginalName(),
        ]);

        $this->notify($quote);

        return $this->done();
    }

    /** Email the right inbox, if one is configured. The request is already saved either way. */
    private function notify(QuoteRequest $quote): void
    {
        $to = $quote->recipient();

        if (! $to) {
            Log::warning("Quote request #{$quote->id} saved but no notification address is configured (MAIL_SALES_TO).");

            return;
        }

        try {
            Mail::to($to)->send(new QuoteRequestReceived($quote));
            $quote->update(['emailed_at' => now()]);
        } catch (Throwable $e) {
            report($e); // never lose the customer's request because mail failed
        }
    }

    private function done(): RedirectResponse
    {
        return redirect()->route('contact')->with('status', self::SUCCESS);
    }
}
