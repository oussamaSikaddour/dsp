@props([
    'model' => null,
    'htmlId',
    'value' => null,
    'label' => '',
    'checked' => false,
    'live' => false,
])

@php
    $wireModel = $model
        ? ($live
            ? "wire:model.live=\"{$model}\""
            : "wire:model=\"{$model}\"")
        : '';
@endphp

<div class="fragment" id="frg-{{ $htmlId }}">
    <input
        {!! $wireModel !!}
        wire:key="{{ $htmlId }}"
        type="checkbox"
        value="{{ $value }}"
        id="{{ $htmlId }}"
        role="checkbox"
        @checked($checked)
        {{ $attributes->merge(['class' => 'checkbox-input']) }}
    />

    @if($label)
        <label for="{{ $htmlId }}" tabindex="0">
            {{ $label }}
        </label>
    @endif
</div>
