<div class="dynamic__fields__container">

    <div class="dynamic__fields__header">
        <p>{{ $label }} :</p>

        @if (count($items) < 10)
            <x-core.button
                type="button"
                function="addItem"
                variant="primary"
                rounded="true"
                icon="add"
                hasTooltip="true"
                :tooltip="$addTooltip"
            />
        @endif
    </div>

    <div class="dynamic__fields__body">

        @foreach ($items as $i => $item)

            <div class="dynamic__field add" wire:key="location-{{ $i }}">

                <div class="row">

                    {{-- LOCATION SELECT --}}
                    <x-core.form.selector
                        htmlId="location-{{ $i }}"
                        model="items.{{ $i }}.location_id"
                        :label="__('forms.locations.location')"
                        :data="$locationsOptions"
                        :showError="true"
                        type="filter"
                    />

                    {{-- CAPACITY INPUT --}}
                    <x-core.form.input
                        html_id="capacity-{{ $i }}"
                        model="items.{{ $i }}.capacity"
                        type="number"
                        :label="__('forms.locations.capacity')"
                        min="1"
                        :showError="true"
                    />

                </div>

                @if (count($items) > 1)
                    <x-core.button
                        type="button"
                        function="removeItem"
                        :parameters="[$i]"
                        variant="danger"
                        icon="cancel"
                        hasTooltip="true"
                        :tooltip="$removeTooltip"
                    />
                @endif

            </div>

        @endforeach

    </div>

</div>
