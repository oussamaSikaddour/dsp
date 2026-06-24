@php
    $formModel = fn(string $field) => "{$form}.{$field}";
@endphp

<div class="modal__body__content">

    <div class="form__container">

        <form class="form" wire:submit="handleSubmit">

            <!-- ===================== -->
            <!-- BASIC INFO -->
            <!-- ===================== -->

            <div class="row center">

                <x-core.form.input model="{{ $formModel('name_fr') }}" :label="__('forms.schedule.name_fr')" type="text"
                    html_id="Mschedule-name-fr" />

                <x-core.form.input model="{{ $formModel('name_en') }}" :label="__('forms.schedule.name_en')" type="text"
                    html_id="Mschedule-name-en" />

                <x-core.form.input model="{{ $formModel('name_ar') }}" :label="__('forms.schedule.name_ar')" type="text"
                    html_id="Mschedule-name-ar" />

            </div>

            <!-- ===================== -->
            <!-- PERIOD INFO -->
            <!-- ===================== -->

            <div class="row center">

                <x-core.form.selector htmlId="Mschedule-year" model="{{ $formModel('year') }}" :label="__('forms.schedule.year')"
                    :data="$yearsOptions" :showError="true" />

                <x-core.form.selector htmlId="Mschedule-month" model="{{ $formModel('month') }}" :label="__('forms.schedule.month')"
                    :data="$monthsOptions" :showError="true" />


            </div>
            <div class="row center">
                          <x-core.form.selector htmlId="Mschedule-apointment-duratoin" model="{{ $formModel('appointment_duration') }}" :label="__('forms.schedule.appointment_duration')"
                    :data="$appointmentDurationOptions" :showError="true" />
            </div>


            <!-- ===================== -->
            <!-- WORKING DAYS -->
            <!-- ===================== -->

            <div class="row center">

                <div class="column">

                    <p>@lang('forms.schedule.working_days')</p>

                    <div class="choices">

                        @foreach ($workingDaysOptions as $key => $label)
                            <x-core.form.check-box model="{{ $formModel('working_days') }}" value="{{ $key }}"
                                label="{{ $label }}" htmlId="wd-{{ $key }}" />
                        @endforeach

                    </div>

                </div>

            </div>

            <!-- ===================== -->
            <!-- WORKING PERIODS -->
            <!-- ===================== -->

            <div class="column">

                <livewire:core.periods-dynamic-field wire:model="{{ $formModel('working_periods') }}"
                    :label="__('forms.schedule.working_periods')" :addTooltip="__('forms.common.actions.add')" :removeTooltip="__('forms.common.actions.remove')" />


                <livewire:core.daysoff-dynamic-field wire:model="{{ $formModel('days_off') }}" :label="__('forms.schedule.days_off')"
                    :addTooltip="__('forms.common.actions.add')" :removeTooltip="__('forms.common.actions.remove')" />


                <livewire:app.appointments-locations-dynamic-field
                    wire:model="{{ $formModel('appointments_locations') }}" :label="__('forms.schedule.appointments_locations')" :addTooltip="__('forms.common.actions.add')"
                    :removeTooltip="__('forms.common.actions.remove')" />


                <x-core.form.textarea model="{{ $formModel('description_fr') }}" :label="__('forms.schedule.description_fr')"
                    html_id="schedule-descriptionFr" />
                <x-core.form.textarea model="{{ $formModel('description_ar') }}" :label="__('forms.schedule.description_ar')"
                    html_id="schedule-descriptionAr" />
                <x-core.form.textarea model="{{ $formModel('description_en') }}" :label="__('forms.schedule.description_en')"
                    html_id="schedule-descriptionEn" />


            </div>

            <!-- ===================== -->
            <!-- ACTIONS -->
            <!-- ===================== -->

            <div class="form__actions">

                <x-core.button type="submit" variant="primary" :text="__('forms.common.actions.submit')" icon="confirm" expectLoading="true"
                    fullWidth="true" :wireTargets="['handleSubmit']" />

            </div>

        </form>

    </div>

</div>
