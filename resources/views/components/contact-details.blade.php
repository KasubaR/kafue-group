@php $a = config('site.address'); @endphp
<dl {{ $attributes }}>
    <dt>Office</dt><dd>{{ $a['street'] }}, {{ $a['city'] }},<br>{{ $a['region'] }}, {{ $a['postcode'] }}, {{ $a['country'] }}</dd>
    <dt>Phone</dt><dd><a href="{{ config('site.phone_href') }}">{{ config('site.phone') }}</a></dd>
    <dt>Email</dt><dd><a href="mailto:{{ config('site.email') }}">{{ config('site.email') }}</a></dd>
</dl>
