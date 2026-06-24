@php
    $inputClasses = 'input';

    if ($errors->has($model)) {
        $inputClasses .= ' input--error';
    }

    if ($variant) {
        $inputClasses .= " input--{$variant}";
    }

    if (!empty($extraClasses)) {
        $inputClasses .= ' ' . (is_array($extraClasses) ? implode(' ', $extraClasses) : $extraClasses);
    }

    $inputType = $type === 'money' ? 'text' : $type;
@endphp

<div class="input__item">
    <div class="input__group">
        <input
            x-data
            x-on:click="$wire.showComboboxTable()"
            x-on:keydown.enter.prevent="$wire.showComboboxTable()"
            x-on:keydown.space.prevent="$wire.showComboboxTable()"
            name="{{ $model ? $model . '_label' : '' }}"
            type="{{ $inputType }}"
            class="{{ $inputClasses }}"
            placeholder="{{ $placeHolder ?? $label }}"
            id="{{ $htmlId }}"
            value="{{ $displayValue ?? '' }}"
            autocomplete="off"
            readonly
            role="combobox"
            aria-expanded="false"
            aria-controls="comboboxTableContainer"
            aria-describedby="{{ $htmlId }}-error"
            @if ($min !== null) min="{{ $min }}" @endif
            @if ($max !== null) max="{{ $max }}" @endif
        />

        <input
            type="hidden"
            name="{{ $model }}"
            wire:model="value"
        />

        @if ($label)
            <label for="{{ $htmlId }}" class="input__label">{{ $label }}</label>
        @endif

        @if ($iconHtml)
            <span class="input__span">
                {!! $iconHtml !!}
            </span>
        @endif
    </div>

    @error($model)
        <div id="{{ $htmlId }}-error" class="input__error">
            ⚠ {{ $message }}
        </div>
    @enderror
</div>
