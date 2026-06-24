
    <div class="form__container">
        <form class="form" wire:submit.prevent="handleSubmit">

            @if (isset($this->existingTypes) && !empty($this->existingTypes))

                <div class="choices" role="groupe" aria-labelledby="checkbox-choices">
                    @foreach ($this->existingTypes as $key => $value)
                        <x-core.form.check-box
                            model="form.types"
                            value="{{ $key }}"
                            label="{{ config('core.options.ESTABLISHMENT_TYPES')[app()->getLocale()][$key] }}"
                            htmlId="type-m-{{ $key }}"
                        />
                    @endforeach

                    @error('form.types')
                        <div class="input__error">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

            @endif

            <div class="form__actions">
                <x-core.button
                    type="submit"
                    variant="primary"
                    :text="__('forms.common.actions.submit')"
                    icon="confirm"
                    expectLoading=true
                    fullWidth=true
                />
            </div>

        </form>
    </div>


@script
<script>
    const typeChoices = document.querySelector(".choices");

    if (typeChoices) {

        const typeChoicesLabels = typeChoices.querySelectorAll("label");
        const typeChoicesInputs = typeChoices.querySelectorAll("input[type='checkbox']");

        typeChoicesLabels.forEach((label, index) => {

            label.addEventListener('keydown', (e) => {

                if (e.key === ' ') {

                    const checkBoxCheckedEvent = new CustomEvent(
                        'checkbox-checked-event',
                        {
                            detail: {
                                checkBox: typeChoicesInputs[index]
                            }
                        }
                    );

                    document.dispatchEvent(checkBoxCheckedEvent);

                    @this.updatetypesOnKeydownEvent(
                        typeChoicesInputs[index].value
                    );
                }
            });

        });

    }
</script>
@endscript
