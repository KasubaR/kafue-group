<x-layouts.app>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/pages/home.css') }}">
    @endpush

    <section class="hero">
        <div class="container">
            <div>
                <x-eyebrow light>Industrial supply for mining and construction</x-eyebrow>
                <h1>Supplying the materials that build Africa's mines and infrastructure.</h1>
                <p class="lead">Kafue Group sources and supplies materials and equipment for mining operations, construction contractors and major infrastructure projects. We handle procurement, inspection and delivery so your team can focus on the work.</p>
                <div class="actions">
                    <x-button :href="route('contact').'#quote'">Send us your RFQ</x-button>
                    <x-button :href="route('products')" variant="ghost">View product range</x-button>
                </div>
            </div>
            <div class="mark"><img src="{{ asset('images/africa-mark.svg') }}" alt=""></div>
        </div>
    </section>

    <x-section id="products">
        <x-section-heading eyebrow="What we supply"
            aside="Consolidate your purchasing across categories and reduce the number of vendors your procurement team has to manage.">
            One supplier for the whole<br>bill of materials
        </x-section-heading>
        <div class="grid-4">
            @foreach (config('content.supply') as $item)
                <x-product-card :title="$item['title']" :icon="$item['icon']" :category="$item['category']" :image="'images/products/'.$item['image'].'.jpg'">{{ $item['text'] }}</x-product-card>
            @endforeach
        </div>
    </x-section>

    <x-section id="project-supply" tone="white">
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

    <x-section id="how-we-work">
        <x-section-heading eyebrow="How we work">
            From RFQ to site, one<br>accountable partner
        </x-section-heading>
        <div class="steps">
            @foreach (config('content.steps') as $i => $step)
                <x-process-step :number="$i + 1" :title="$step['title']">{{ $step['text'] }}</x-process-step>
            @endforeach
        </div>
    </x-section>

    <section class="why">
        <div class="container">
            <div class="why-card">
                <div>
                    <x-eyebrow light>Why Kafue Group</x-eyebrow>
                    <h2>Rooted in Africa, connected to the world's manufacturers</h2>
                    <p class="lead">Our name comes from the Kafue, a river that links many landscapes into one system. That is how we work: bringing many manufacturers, freight routes and specialists together into a single, dependable supply line for your project.</p>
                </div>
                <ul>
                    @foreach (config('content.why') as $item)
                        <x-check-item :bold="$item['bold']">{{ $item['text'] }}</x-check-item>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

</x-layouts.app>
