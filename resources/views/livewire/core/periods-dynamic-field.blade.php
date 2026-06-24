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

            <div class="dynamic__field add" wire:key="period-{{ $i }}">

                <div class="row">



                    <x-core.form.selector
                    htmlId="period-start-{{ $i }}"
                    model="items.{{ $i }}.start"
                    :label="__('forms.period.start')"
                    :data="$hoursOptions"
                    :showError="true"
                    type="filter"
                />

                    <x-core.form.selector
                    htmlId="period-end-{{ $i }}"
                    model="items.{{ $i }}.end"
                    :label="__('forms.period.end')"
                    :data="$hoursOptions"
                    :showError="true"
                    type="filter"
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
