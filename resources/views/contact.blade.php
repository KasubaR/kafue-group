<x-layouts.app title="Contact | Kafue Group" description="Request a quotation from Kafue Group. Send us your bill of materials or spares list for pricing, lead times and a delivery plan.">
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/pages/contact.css') }}">
    @endpush
    @push('scripts')
        <script src="{{ asset('js/quote-form.js') }}" defer></script>
    @endpush

    <x-page-hero eyebrow="Contact" title="Request a quotation">
        Tell us what you need and where it needs to go. Our team will come back to you with pricing, lead times and a delivery plan.
    </x-page-hero>

    <section class="contact" id="quote">
        <div class="container">
            <div>
                <x-eyebrow>Get in touch</x-eyebrow>
                <h2>Send us your RFQ</h2>
                <p class="lead">Share a bill of materials, cutting list, spares list or drawing and we will confirm specifications and delivery needs.</p>
                <x-contact-details />
            </div>
            <x-quote-form :categories="$categories" />
        </div>
    </section>
</x-layouts.app>
