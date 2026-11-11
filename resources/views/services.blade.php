@php
    $quote = fn (?string $category = null) => route('contact', array_filter(['category' => $category])).'#quote';

    // Where each service card goes: [href, link label]. Anything not listed opens the quote form.
    $serviceLinks = [
        'Project supply' => ['#projects', 'See how it works'],
        'Equipment rental' => ['#rental', 'See the fleet'],
        'Tool store management' => [route('products').'#tools', 'See the tools range'],
        'Repairs and calibration' => [route('products').'#tools', 'See the tools range'],
        'Inspection and tagging' => [route('products').'#tools', 'See the tools range'],
    ];
@endphp
<x-layouts.app title="Services | Kafue Group" description="Project supply, steel processing, equipment rental, tool store management, repairs and calibration, inspection, urgent sourcing and logistics for mining and construction projects.">
    <x-page-hero eyebrow="Services" title="Services that keep projects moving">
        More than supply: from project call-offs and steel processing to equipment rental, urgent sourcing and logistics.
    </x-page-hero>

    <x-anchor-menu :links="[['services', 'Services'], ['projects', 'Project stages'], ['rental', 'Buy or rent'], ['process', 'How we work'], ['sectors', 'Sectors']]" />

    {{-- The eight services --}}
    <x-section id="services">
        <x-section-heading eyebrow="More than supply"
            aside="One accountable partner for sourcing, inspection, freight and customs clearing, so your team deals with one supplier instead of many.">
            Eight services, one<br>point of contact
        </x-section-heading>
        <div class="grid-4">
            @foreach (config('content.services') as $service)
                @php [$href, $label] = $serviceLinks[$service['title']] ?? [$quote(), 'Ask about this']; @endphp
                <x-info-card :title="$service['title']" :href="$href" :link-label="$label">{{ $service['text'] }}</x-info-card>
            @endforeach
        </div>

        <x-callout title="Breakdown or shutdown?" :button-label="'Call '.config('site.phone')" :href="config('site.phone_href')">
            Our urgent sourcing service is for breakdowns and shutdowns, when critical equipment fails and every hour of downtime counts.
        </x-callout>
    </x-section>

    {{-- Project stages --}}
    <x-section id="projects" tone="white">
        <x-section-heading eyebrow="Project supply">
            Structured for every stage of a<br>major project
        </x-section-heading>
        <p class="intro">Large projects need a supplier that can plan ahead and react fast. We work alongside building and civil contractors, EPC firms, developers and mine maintenance teams from groundbreaking to handover and beyond.</p>
        <div class="grid-4">
            @foreach (config('content.stages') as $i => $stage)
                <x-stage-card :number="$i + 1" :title="$stage['title']">{{ $stage['text'] }}</x-stage-card>
            @endforeach
        </div>
    </x-section>

    {{-- Equipment rental --}}
    <x-section id="rental">
        <x-section-heading eyebrow="Buy or rent">
            Equipment for the project,<br>without the capital outlay
        </x-section-heading>
        <p class="intro">Buy what you will keep and rent what you need only for construction or a shutdown. Rental fleets are delivered, serviced and collected, with technical support on site when needed.</p>
        <div class="grid-3">
            @foreach (config('content.rental') as $item)
                <x-info-card :title="$item['title']" :tag="$item['tag']">{{ $item['text'] }}</x-info-card>
            @endforeach
        </div>
        <div class="section-actions">
            <x-button :href="$quote('Tools and equipment')">Ask about rentals</x-button>
        </div>
    </x-section>

    {{-- How we work --}}
    <x-section id="process" tone="white">
        <x-section-heading eyebrow="How we work">
            From RFQ to site, one<br>accountable partner
        </x-section-heading>
        <div class="steps">
            @foreach (config('content.steps') as $i => $step)
                <x-process-step :number="$i + 1" :title="$step['title']">{{ $step['text'] }}</x-process-step>
            @endforeach
        </div>
    </x-section>

    {{-- Sectors served --}}
    <x-section id="sectors">
        <x-section-heading eyebrow="Sectors served">
            Mining and construction<br>across Africa
        </x-section-heading>
        <div class="grid-3">
            @foreach (config('content.sectors') as $sector)
                <x-info-card :title="$sector['title']">{{ $sector['text'] }}</x-info-card>
            @endforeach
        </div>
    </x-section>

    <x-cta-band title="Have a bill of materials or a spares list?" button-label="Start a quotation">
        Send it to us and we will come back with pricing, lead times and a delivery plan.
    </x-cta-band>
</x-layouts.app>
