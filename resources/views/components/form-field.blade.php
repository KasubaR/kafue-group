@props([
    'name',
    'label',
    'type' => 'text',   // text | email | date | file | select | textarea
    'options' => [],    // for select
    'required' => false,
    'full' => false,
    'default' => null,  // default selected option for select
    'hint' => null,     // small helper text under the field
    'showFor' => null,  // array of categories this field applies to; js/quote-form.js hides it for others
    'labels' => [],     // alternative labels by key (e.g. ['steel' => '...']); js/quote-form.js swaps them by category
])
<div @class(['field', 'full' => $full]) @if ($showFor) data-show-for='@json($showFor)' @endif>
    <label for="{{ $name }}" @foreach ($labels as $key => $text) data-label-{{ $key }}="{{ $text }}" @endforeach>{{ $label }}</label>

    @if ($type === 'select')
        <select id="{{ $name }}" name="{{ $name }}" {{ $attributes }}>
            @foreach ($options as $option)
                <option value="{{ $option }}" @selected(old($name, $default ?? ($options[0] ?? null)) === $option)>{{ $option }}</option>
            @endforeach
        </select>
    @elseif ($type === 'textarea')
        <textarea id="{{ $name }}" name="{{ $name }}" @required($required) {{ $attributes }}>{{ old($name) }}</textarea>
    @elseif ($type === 'file')
        {{-- Custom drop zone (css/forms.css, js/form-controls.js). Without JS the plain file input shows. --}}
        <div class="dropzone" data-dropzone>
            <input id="{{ $name }}" type="file" name="{{ $name }}" {{ $attributes }}>
            <div class="dropzone-ui" aria-hidden="true">
                <span class="dz-icon">
                    <svg viewBox="0 0 24 24"><path d="M12 16V5M7.5 9.5 12 5l4.5 4.5M5 15v3a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-3"/></svg>
                </span>
                <span class="dz-body">
                    <span class="dz-text"><strong>Choose a file</strong> or drag it here</span>
                    <span class="dz-file" hidden></span>
                </span>
            </div>
            <button class="dz-clear" type="button" hidden>Remove</button>
        </div>
    @else
        <input id="{{ $name }}" @if ($type !== 'text') type="{{ $type }}" @endif name="{{ $name }}" value="{{ old($name) }}" @required($required) {{ $attributes }}>
    @endif

    @if ($hint)<div class="hint">{{ $hint }}</div>@endif
    @error($name)<div class="error">{{ $message }}</div>@enderror
</div>
