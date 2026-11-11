New quote request from the website

Category:   {{ $quote->category }}
Name:       {{ $quote->name }}
Company:    {{ $quote->company ?: '-' }}
Email:      {{ $quote->email }}
Phone:      {{ $quote->phone ?: '-' }}
Project / site: {{ $quote->project ?: '-' }}
@if ($quote->site_country)
Country:    {{ $quote->site_country }}
@endif
@if ($quote->required_by)
Required on site by: {{ $quote->required_by->format('j F Y') }}
@endif
@if ($quote->attachment_name)
Attachment: {{ $quote->attachment_name }} (attached)
@endif

Items, quantities and delivery:
{{ $quote->details }}

--
Received {{ $quote->created_at->format('j F Y H:i') }} (request #{{ $quote->id }}).
Reply to this email to answer the customer directly.
