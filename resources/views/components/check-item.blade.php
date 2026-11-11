@props(['bold'])
<li {{ $attributes }}>
    <x-icon name="check" />
    <span><strong>{{ $bold }}</strong> {{ $slot }}</span>
</li>
