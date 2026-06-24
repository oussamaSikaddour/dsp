@props([
    'model',
    'label',
    'type' => 'text',
    'html_id',
    'role' => '',
    'min' => null,
    'max' => null,
    'placeHolder' => null,
    'default' => true,
    'disabled' => false,
])


@if ($default)
    <div class="input__item">
        <div class="input__group">
            <input
                name="{{ $model }}"
                type="{{ $type }}"
                class="input {{ $errors->has($model) ? 'input--error' : '' }}"
                placeholder="{{ $label }}"
                id="{{ $html_id }}"
                wire:model{{ $role === 'filter' ? '.live.debounce.300ms' : '' }}="{{ $model }}"
                @if ($min) min="{{ $min }}" @endif
                @if ($max) max="{{ $max }}" @endif
                @if ($type === 'money')
                    x-data
                    x-on:blur="$event.target.value = parseFloat($event.target.value || 0).toFixed(2)"
                @endif
                @disabled($disabled)
                aria-describedby="{{ $html_id }}-error"
                {{ $attributes->except('disabled') }}
            />
            <label for="{{ $html_id }}" class="input__label">{{ $label }}</label>
        </div>

        @error($model)
            <div id="{{ $html_id }}-error" class="input__error">
                ⚠ {{ $message }}
            </div>
        @enderror
    </div>
@else
    <div class="form-group">
        <div class="form-field">
            <input
                name="{{ $model }}"
                type="{{ $type }}"
                class="form-control"
                placeholder="{{ $placeHolder }}"
                id="{{ $html_id }}"
                wire:model{{ $role === 'filter' ? '.live.debounce.300ms' : '' }}="{{ $model }}"
                @if ($min) min="{{ $min }}" @endif
                @if ($max) max="{{ $max }}" @endif
                @if ($type === 'money')
                    x-data
                    x-on:blur="$event.target.value = parseFloat($event.target.value || 0).toFixed(2)"
                @endif
                @disabled($disabled)
                aria-describedby="{{ $html_id }}-error"
                {{ $attributes->except('disabled') }}
            >
        </div>

        @error($model)
            <div id="{{ $html_id }}-error" class="error-message">
                ⚠ {{ $message }}
            </div>
        @enderror
    </div>
@endif
