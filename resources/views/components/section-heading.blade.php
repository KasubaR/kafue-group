@props(['eyebrow', 'aside' => null])
{{-- Heading goes in the default slot (use <br> for line breaks). Pass an "aside" slot for the right-hand blurb. --}}
@if ($aside)
    <div class="section-head">
        <div>
            <x-eyebrow>{{ $eyebrow }}</x-eyebrow>
            <h2>{{ $slot }}</h2>
        </div>
        <p>{{ $aside }}</p>
    </div>
@else
    <x-eyebrow>{{ $eyebrow }}</x-eyebrow>
    <h2>{{ $slot }}</h2>
@endif
