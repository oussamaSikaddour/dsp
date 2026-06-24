<div class="dynamic__fields__container">

    <div class="dynamic__fields__header">
        <p>{{ $label }} :</p>

        <x-core.button
            type="button"
            function="addItem"
            variant="primary"
            rounded="true"
            icon="add"
            hasTooltip="true"
            :tooltip="$addTooltip"
        />
    </div>

    <div class="dynamic__fields__body">

        @foreach ($items as $i => $item)

            <div class="dynamic__field add" wire:key="dayoff-{{ $i }}">

                <x-core.form.input
                    html_id="dayoff-{{ $i }}"
                    model="items.{{ $i }}"
                    label="Date"
                    type="date"
                />

                @if (count($items) > 0)
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
