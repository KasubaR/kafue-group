@php
    $quote = route('contact').'#quote';
    $registration = [
        ['Enterprise name', config('site.enterprise_name')],
        ['Registered name', config('site.legal_name')],
        ['Enterprise number', config('site.registration')],
    ];
@endphp
<x-layouts.app title="About | Kafue Group" description="Kafue Group (Pty) Ltd is an industrial sourcing and supply company based in Kimberley, Northern Cape, equipping mining, construction and infrastructure projects across Africa.">
    <x-page-hero eyebrow="About us" title="One accountable supply partner for major projects">
        Kafue Group (Pty) Ltd is an industrial sourcing and supply company based in Kimberley, Northern Cape, South Africa.
    </x-page-hero>

    <x-anchor-menu :links="[['who', 'Who we are'], ['values', 'Values'], ['why', 'Why Kafue'], ['compliance', 'Compliance']]" />

    {{-- Who we are --}}
    <x-section id="who">
        <div class="split">
            <div class="prose">
                <x-section-heading eyebrow="Who we are">
                    One accountable supply partner<br>for major projects
                </x-section-heading>
                <p>Kafue Group (Pty) Ltd is an industrial sourcing and supply company that equips mining operations, construction contractors and infrastructure projects across Africa. We are based in Kimberley, Northern Cape, South Africa.</p>
                <p>We supply steel, tools, equipment and site consumables, and we manage the sourcing, inspection, freight and customs clearing that bring them to site. Clients deal with one partner instead of many separate vendors.</p>
            </div>
            <x-pullquote label="Our name">
                The Kafue is a river that joins many landscapes into one living system. We work the same way, bringing many manufacturers, freight routes and specialists together into one dependable supply line.
            </x-pullquote>
        </div>

        <div class="grid-2 spaced">
            <x-info-card title="Vision" tag="Where we are heading">To be the supply partner of choice for the projects that build and run Africa's mines and infrastructure.</x-info-card>
            <x-info-card title="Mission" tag="What we do">To deliver the right materials and equipment to site, on time, fully documented and at a fair price.</x-info-card>
        </div>
    </x-section>

    {{-- Values --}}
    <x-section id="values" tone="white">
        <x-section-heading eyebrow="Our values">
            What you can count on
        </x-section-heading>
        <div class="grid-5 spaced">
            @foreach (config('content.values') as $value)
                <x-info-card :title="$value['title']">{{ $value['text'] }}</x-info-card>
            @endforeach
        </div>
    </x-section>

    {{-- Why clients choose us --}}
    <x-section id="why">
        <div class="split">
            <div>
                <x-section-heading eyebrow="Why clients choose Kafue Group">
                    Fewer vendors, fewer delays,<br>complete paperwork
                </x-section-heading>
                <div class="section-actions">
                    <x-button :href="$quote">Request a quotation</x-button>
                </div>
            </div>
            <ul class="check-list">
                @foreach (config('content.why_clients') as $item)
                    <x-check-item :bold="$item['bold']">{{ $item['text'] }}</x-check-item>
                @endforeach
            </ul>
        </div>
    </x-section>

    {{-- Quality and compliance --}}
    <x-section id="compliance" tone="white">
        <x-section-heading eyebrow="Quality and compliance">
            Registered, documented<br>and vendor ready
        </x-section-heading>
        <p class="intro">Every steel order ships with mill certificates and lifting equipment ships tested and certified. Products are sourced from manufacturers and authorised channels and inspected before dispatch.</p>

        <div class="split even">
            <div>
                <h3 class="block-title">Company registration</h3>
                <x-detail-list :items="$registration" />
            </div>
            <div class="panel">
                <h3>Vendor registration pack</h3>
                <p>Procurement teams can request our complete vendor registration pack instead of chasing documents. Available on request.</p>
                <ul class="check-list">
                    @foreach (config('content.vendor_pack') as $doc)
                        <li><x-icon name="check" /><span>{{ $doc }}</span></li>
                    @endforeach
                </ul>
                <div class="section-actions">
                    <x-button :href="$quote">Request the vendor pack</x-button>
                </div>
            </div>
        </div>
    </x-section>

    <x-cta-band title="Have a bill of materials or a spares list?" button-label="Start a quotation">
        Send it to us and we will come back with pricing, lead times and a delivery plan.
    </x-cta-band>
</x-layouts.app>
