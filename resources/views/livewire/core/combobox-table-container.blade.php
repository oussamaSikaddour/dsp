<div
    class="combobox__table__container"
    id="comboboxTableContainer"
    role="dialog"
    aria-label="Combobox table"
    aria-hidden="true"
    wire:ignore.self
>
    @if (!empty($component) && !empty($component['name']))
        @livewire($component['name'], $component['parameters'] ?? [], key($wireKey))
    @endif
</div>
