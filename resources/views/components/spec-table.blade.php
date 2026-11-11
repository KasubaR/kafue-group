@props(['headings' => [], 'rows' => []])
<div {{ $attributes->class(['spec-table-wrap']) }}>
    <table class="spec-table">
        <thead>
            <tr>@foreach ($headings as $h)<th scope="col">{{ $h }}</th>@endforeach</tr>
        </thead>
        <tbody>
            @foreach ($rows as $row)
                <tr>
                    @foreach ($row as $i => $cell)
                        @if ($i === 0)<th scope="row">{{ $cell }}</th>@else<td data-label="{{ $headings[$i] ?? '' }}">{{ $cell }}</td>@endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
