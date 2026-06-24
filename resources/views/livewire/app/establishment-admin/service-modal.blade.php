@php
    $formModel = fn(string $field) => "{$form}.{$field}";
@endphp

<div class="modal__body__content">

    <div class="form__container">
        <form class="form" wire:submit="handleSubmit">

            {{-- Names --}}
            <div class="row center">

                <x-core.form.input
                    :model="$formModel('name_fr')"
                    :label="__('forms.service.name_fr')"
                    type="text"
                    html_id="MSer-nfr"
                />

                <x-core.form.input
                    :model="$formModel('name_ar')"
                    :label="__('forms.service.name_ar')"
                    type="text"
                    html_id="MSer-nAr"
                />

                <x-core.form.input
                    :model="$formModel('name_en')"
                    :label="__('forms.service.name_en')"
                    type="text"
                    html_id="MSer-nEn"
                />

            </div>

            {{-- Type + Specialty --}}
            <div class="row center">

                <x-core.form.selector
                    htmlId="MSer-st"
                    :model="$formModel('type')"
                    :label="__('forms.service.type')"
                    :data="$serviceTypesOptions"
                    :showError="true"
                />

                <x-core.form.selector
                    htmlId="MSer-Sep"
                    :model="$formModel('specialty_id')"
                    :label="__('forms.service.specialty')"
                    :data="$serviceSpecialtiesOptions"
                    :showError="true"
                />

            </div>

            {{-- Head of Service --}}
            <div class="row center">

                <x-core.form.selector
                    htmlId="MSer-ui"
                    :model="$formModel('head_of_service_id')"
                    :label="__('forms.service.head_of_service_id')"
                    :data="$headOfServiceOptions"
                    :showError="true"
                />

            </div>

            {{-- Contact --}}
            <div class="row center">

                <x-core.form.input
                    :model="$formModel('tel')"
                    :label="__('forms.service.tel')"
                    type="text"
                    html_id="MService-Ph"
                />

                <x-core.form.input
                    :model="$formModel('fax')"
                    :label="__('forms.service.fax')"
                    type="text"
                    html_id="MService-fax"
                />

            </div>

            {{-- Actions --}}
            <div class="form__actions">

                <x-core.button
                    type="submit"
                    variant="primary"
                    icon="confirm"
                    :text="__('forms.common.actions.submit')"
                    expectLoading=true
                    fullWidth=true
                    :wireTargets="['handleSubmit']"
                />

            </div>

        </form>
    </div>

</div>
