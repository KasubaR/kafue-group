@props(['title', 'links' => []])
<div>
    <h4>{{ $title }}</h4>
    @foreach ($links as [$href, $label])
        <a href="{{ $href }}">{{ $label }}</a>
    @endforeach
</div>
