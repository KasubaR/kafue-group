@props(['categories'])
{{--
    One quote form for every kind of request. The category picks which extra fields show
    (js/quote-form.js; without JS every field is visible) and which inbox is notified (config/site.php).
--}}
@php
    $steel = ['Steel and plate'];
    $tools = config('site.mail.tools_categories');
    $maxMb = config('site.attachments.max_kb') / 1024;

    // The attachment label follows the chosen category (also server-side, so it is right before JS runs).
    $attachLabels = [
        'default' => 'Attach drawings or spreadsheets (optional)',
        'steel' => 'Attach your cutting list, drawings or spreadsheets (optional)',
        'tools' => 'Attach a tool list, drawings or spreadsheets (optional)',
    ];
    $selected = old('category', request('category'));
    $attachLabel = $selected === 'Steel and plate' ? $attachLabels['steel']
        : (in_array($selected, $tools, true) ? $attachLabels['tools'] : $attachLabels['default']);
@endphp
<form class="form-card" method="POST" action="{{ route('quote.store') }}" enctype="multipart/form-data" data-quote-form>
    @csrf
    @if (session('status'))
        <div class="alert" role="status">{{ session('status') }}</div>
    @endif

    {{-- Spam trap: hidden from people, irresistible to bots. --}}
    <div class="hp" aria-hidden="true">
        <label for="website">Leave this field empty</label>
        <input id="website" type="text" name="website" tabindex="-1" autocomplete="off">
    </div>

    <div class="form-grid">
        <x-form-field name="name" label="Full name" required />
        <x-form-field name="company" label="Company" />
        <x-form-field name="email" label="Email" type="email" required />
        <x-form-field name="phone" label="Phone" />
        <x-form-field name="category" label="Category" type="select" :options="$categories" :default="request('category')" />
        <x-form-field name="project" label="Project or site" />
        <x-form-field name="required_by" label="Required on site by" type="date" :show-for="$steel" />
        <x-form-field name="site_country" label="Country and site" :show-for="$tools" />
        <x-form-field name="details" label="Items, quantities and required delivery date" type="textarea" required full
            data-placeholder-default="List the items, quantities and where they need to go."
            data-placeholder-steel="List sections, grades, sizes, lengths and quantities, or attach your cutting list."
            data-placeholder-tools="List the tools, models and quantities, or attach your tool list." />
        <x-form-field name="attachment" :label="$attachLabel" :labels="$attachLabels" type="file" full
            accept=".{{ implode(',.', config('site.attachments.types')) }}"
            data-max-kb="{{ config('site.attachments.max_kb') }}"
            :hint="'PDF, spreadsheet, document or image, up to '.$maxMb.' MB.'" />
    </div>

    <div class="form-foot">
        <small>You can also email your BOM or spares list as a spreadsheet.</small>
        <x-button type="submit">Submit request</x-button>
    </div>
</form>
