@php
    $quote = fn (?string $category = null) => route('contact', array_filter(['category' => $category])).'#quote';
    $links = config('content.division_links');
@endphp
<x-layouts.app title="Products | Kafue Group" description="Steel, tools, welding and cutting, pumps and flow, safety and PPE, lifting, fasteners and lubricants for mining, construction and infrastructure projects.">
    <x-page-hero eyebrow="Products" title="Eight divisions, one order">
        A full bill of materials goes on one order, one invoice and one consolidated delivery.
    </x-page-hero>

    <x-anchor-menu :links="[['divisions', 'All divisions'], ['steel', 'Steel'], ['tools', 'Tools']]" />

    {{-- All eight divisions --}}
    <x-section id="divisions">
        <x-section-heading eyebrow="What we supply"
            aside="Consolidate your purchasing across categories and reduce the number of vendors your procurement team has to manage.">
            Everything for the bill<br>of materials
        </x-section-heading>
        <div class="grid-4">
            @foreach (config('content.divisions') as $division)
                @php
                    $link = $links[$division['title']] ?? [];
                    $onPage = isset($link['anchor']);
                @endphp
                <x-info-card :title="$division['title']"
                    :href="$onPage ? '#'.$link['anchor'] : $quote($link['category'] ?? null)"
                    :link-label="$onPage ? 'See the range' : 'Request a quote'">{{ $division['text'] }}</x-info-card>
            @endforeach
        </div>
    </x-section>

    {{-- Steel division --}}
    <x-section id="steel" tone="white">
        <x-section-heading eyebrow="Steel division">
            Steel for structures, plant<br>and wear
        </x-section-heading>
        <p class="intro">Standard and heavy sections, plate in mild, high strength and abrasion resistant grades, and value added processing so steel arrives ready to fabricate.</p>

        <x-chip-list :items="config('content.steel.groups')" />

        <x-spec-table :headings="['Product', 'Typical grades', 'Used for']" :rows="config('content.steel.table')" />

        <div class="sub-head" data-reveal>
            <h3>Arrives ready to fabricate</h3>
            <p>Every steel order ships with mill certificates. Add processing and we deliver it cut, prepared and tagged.</p>
        </div>
        <div class="grid-4">
            @foreach (config('content.steel.processing') as $step)
                <x-info-card :title="$step['title']">{{ $step['text'] }}</x-info-card>
            @endforeach
        </div>

        <div class="section-actions">
            <x-button :href="$quote('Steel and plate')">Get a steel quote</x-button>
        </div>
    </x-section>

    {{-- Tools division --}}
    <x-section id="tools">
        <x-section-heading eyebrow="Tools division">
            The right tool in every hand,<br>on every shift.
        </x-section-heading>
        <p class="intro">Power tools, hand tools, measuring instruments and complete trade kits for mining, construction and engineering crews. Backed by on site tool store management, repairs and calibration.</p>

        <div class="highlights">
            @foreach (config('content.tools.highlights') as $item)
                <div class="highlight" data-reveal>
                    <h3>{{ $item['title'] }}</h3>
                    <p>{{ $item['text'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="sub-head flush" data-reveal>
            <h3>Shop by category</h3>
            <p>Every item can be quoted individually or bundled into a kit.</p>
        </div>
        <x-chip-list :items="config('content.tools.categories')" />

        <div class="sub-head flush" data-reveal>
            <h3>Cordless and corded power tools</h3>
            <p>Drills, impact wrenches, grinders and saws on high voltage cordless platforms, so one battery system powers the whole crew.</p>
        </div>
        <div class="grid-3">
            @foreach (config('content.tools.power_tools') as $tool)
                <x-info-card :title="$tool['title']" :tag="$tool['tag']" :href="$quote('Tools and equipment')" link-label="Request price">{{ $tool['text'] }}</x-info-card>
            @endforeach
        </div>

        <div class="sub-head" data-reveal>
            <h3>Trade kits</h3>
            <p>Kit out a new artisan in one order. Standard kits are built around each trade, packed in a lockable box or trolley, with a contents list for your tool store. We can adjust any kit to your site standard.</p>
        </div>
        <div class="grid-3">
            @foreach (config('content.tools.kits') as $kit)
                <x-info-card :title="$kit['title']" :href="$quote('Tools and equipment')" link-label="Get kit pricing">{{ $kit['text'] }}</x-info-card>
            @endforeach
        </div>

        <div class="section-actions">
            <x-button :href="$quote('Tools and equipment')">Send us your tool list</x-button>
            <x-button :href="route('services')" variant="outline">Tool store services</x-button>
        </div>
    </x-section>

    <x-cta-band title="Have a bill of materials or a spares list?" button-label="Start a quotation">
        Send it to us and we will come back with pricing, lead times and a delivery plan.
    </x-cta-band>
</x-layouts.app>
