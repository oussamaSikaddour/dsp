@php
    $formModel = fn(string $field) => "{$form}.{$field}";
@endphp

<div class="modal__body__content">

    <div class="form__container">

        <form class="form" wire:submit="handleSubmit">

            <!-- DAY DATE -->
            <div class="row center">

                <x-core.form.input :model="$formModel('day_at')" type="date" :label="__('Day')" html_id="schedule-day-at"
                    :disabled="$scheduleDayId" />

                    <x-core.form.selector htmlId="MscheduleDay-apointment-duratoin" model="{{ $formModel('appointment_duration') }}" :label="__('forms.schedule_day.appointment_duration')"
                    :data="$appointmentDurationOptions" :showError="true" />

            </div>

            <!-- WORKING PERIODS -->
            <div class="column">

                <livewire:core.periods-dynamic-field wire:model="{{ $formModel('working_periods') }}"
                    :label="__('Working periods')" />

                <livewire:app.appointments-locations-dynamic-field
                    wire:model="{{ $formModel('appointments_locations') }}" :label="__('Locations')" />

            </div>

            <!-- ACTIONS -->
            <div class="form__actions">

                <x-core.button type="submit" variant="primary" text="Save" icon="confirm" fullWidth="true"
                    :wireTargets="['handleSubmit']" />

            </div>

        </form>

    </div>

</div>
