<?php

namespace App\Mail;

use App\Models\QuoteRequest;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class QuoteRequestReceived extends Mailable
{
    public function __construct(public QuoteRequest $quote) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "New quote request: {$this->quote->category} ({$this->quote->name})",
            replyTo: [new Address($this->quote->email, $this->quote->name)],
        );
    }

    public function content(): Content
    {
        return new Content(text: 'emails.quote-request');
    }

    public function attachments(): array
    {
        if (! $this->quote->attachment_path) {
            return [];
        }

        return [
            Attachment::fromStorageDisk('local', $this->quote->attachment_path)
                ->as($this->quote->attachment_name),
        ];
    }
}
