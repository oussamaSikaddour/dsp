<div class="table__container" x-on:update-appointments-table.window="$wire.$refresh()">
    {{-- Header --}}
    <div class="table__header">
        <h3>
            {{ __(
                'tables.appointments.info.' . (!$isForServicePersonnel ? 'relative' : 'patients'),
                !$isForServicePersonnel ? ['name' => $patient] : [],
            ) }}
        </h3>

        <div class="table__header__actions">
            <x-core.button icon="filter" rounded=true hasTooltip=true :tooltip="__('toolTips.common.filters')" :extraClasses="['table__filters__btn']" />

            @if ($isForServicePersonnel)
                <x-core.button icon="download" variant="success" rounded=true hasTooltip=true :tooltip="__('toolTips.appointment.export')"
                    function="generateAppointmentsPdf" />
            @endif

            <x-core.form.selector htmlId="APP-upp" model="perPage" :data="$perPageOptions" type="filter" :tooltip="__('toolTips.common.per_page')" />
        </div>
    </div>

    {{-- Filters --}}
    <div class="table__filters" wire:ignore>
        <div class="form__container">
            <form class="form">
                {{-- Common filters --}}
                <div class="row">
                    <x-core.form.selector htmlId="APP-Year" model="year" :label="__('tables.appointments.year')" :data="$yearsOptions"
                        type="filter" />
                    <x-core.form.selector htmlId="APP-Month" model="month" :label="__('tables.appointments.month')" :data="$monthsOptions"
                        type="filter" />
                </div>

                {{-- Conditional filters for non-simple users --}}
                @if ($isForServicePersonnel )
                    <div class="row">
                        <x-core.form.input html_id="APP-patient" model="patient" :label="__('tables.appointments.patient')" type="text"
                            role="filter" />
                        <x-core.form.input html_id="APP-code" model="patientCode" :label="__('tables.appointments.code')" type="text"
                            role="filter" />
                    </div>

                  @can('doctor-access')
                                  <div class="row">
                            <x-core.form.selector htmlId="APP-specialty" model="specialtyId" :label="__('tables.appointments.specialty')"
                                :data="$specialtiesOptions" type="filter" />
                            <x-core.form.selector htmlId="APP-service" model="serviceId" :label="__('tables.appointments.service')"
                                :data="$serviceOptions" type="filter" />
                        </div>

                  @endcan


                    @cannot('appointments-locations-agent-access')
                        <div class="row">
                            <x-core.form.selector htmlId="APP-daira" model="dairaId" :label="__('tables.appointments.daira')" :data="$dairatesOptions"
                                type="filter" />
                            <x-core.form.selector htmlId="APP-location" model="appointmentsLocationId" :label="__('tables.appointments.location')"
                                :data="$appointmentsLocationsOptions" type="filter" />
                        </div>
                    @endcannot
                @endif

                {{-- Common date filter --}}
                <div class="row">
                    <x-core.form.input html_id="APP-date" model="scheduleDayDate" :label="__('tables.appointments.date')" type="date"
                        role="filter" />
                </div>

                {{-- Form actions --}}
                <div class="form__actions">
                    <x-core.button type="button" variant="primary" function="resetFilters" rounded=true
                        icon="refresh" />
                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    @if ($this->confirmedAppointments->isNotEmpty())
        <div class="table__body">
            <table class="table">
                <thead>
                    <tr>
                        <th>@lang('tables.common.actions')</th>

                        {{-- Additional columns for non-simple users --}}


                        @if ($isForServicePersonnel )
                            <x-core.table.sortable-th model="patient_code" :label="__('tables.appointments.code')" :$sortDirection
                                :$sortBy />
                            <x-core.table.sortable-th model="patient_name" :label="__('tables.appointments.patient')" :$sortDirection
                                :$sortBy />
                        @else
                            <x-core.table.sortable-th model="location_name" :label="__('tables.appointments.location')" :$sortDirection
                                :$sortBy />
                        @endif

                       @can('doctor-access')
                                  <x-core.table.sortable-th model="service" :label="__('tables.appointments.service')" :$sortDirection :$sortBy />
                            <x-core.table.sortable-th model="specialty" :label="__('tables.appointments.specialty')" :$sortDirection :$sortBy />
                       @endcan



                        <x-core.table.sortable-th model="type" :label="__('tables.appointments.type')" :$sortDirection :$sortBy />
                        <x-core.table.sortable-th model="day_at" :label="__('tables.appointments.date')" :$sortDirection :$sortBy />
                        <x-core.table.sortable-th model="start_at" :label="__('tables.appointments.start_at')" :$sortDirection :$sortBy />
                    </tr>
                </thead>

                <tbody>
                    @foreach ($this->confirmedAppointments as $appointment)
                        <tr wire:key="appointment-{{ $appointment->id }}">
                            {{-- Actions --}}
                            <td>


                                 @can('doctor-access')
                                      <x-core.button icon="visit" variant="info" route="medical_exams_route"
                                        :routeParameters="[
                                            'id' => $appointment->patient_id,
                                            'appointmentId'=>$appointment->id,
                                            'isComingFromAppointmentTable'=>true
                                        ]" rounded hasTooltip :tooltip="__('toolTips.patient.view.exam')" />
                                 @endcan



                                @if (!($isForServicePersonnel))
                                    <x-core.button variant="danger" icon="cancel" function="openCancelDialog"
                                        :parameters="[$appointment]" rounded=true hasTooltip=true :tooltip="__('toolTips.appointment.cancel')" />
                                @endif

                                @if ($appointment->type == 'initial')
                                    <livewire:core.open-modal-button variant="info"
                                        wire:key="u-referral-letter-{{ $appointment->id }}" rounded=true hasTooltip=true
                                        :tooltip="__('toolTips.appointment.referral_letter')" icon="article" modalTitle="modals.appointment.actions.view"
                                        :modalTitleOptions="['date' => $appointment->day_at]" :modalContent="[
                                            'name' => 'app.referral-letter-modal',
                                            'parameters' => [
                                                'appointmentId' => $appointment->id,
                                                'isForServicePersonnel' => $isForServicePersonnel,
                                            ],
                                        ]" />
                                @endif

                                <x-core.button variant="primary" icon="print"
                                    function="generateAppointmentConfirmationPdf" :parameters="[$appointment]" rounded=true
                                    hasTooltip=true :tooltip="__('toolTips.appointment.get_confirmation')" />

                                <x-core.button icon="map" function="openGoogleMap" :parameters="[$appointment->longitude, $appointment->latitude]" rounded
                                    hasTooltip :tooltip="__('toolTips.appointment.location')" />
                            </td>

                            {{-- Additional data for non-simple users --}}
                            @if ($isForServicePersonnel)
                                <td>{{ $appointment->patient_code ?? '-' }}</td>
                                <td>{{ $appointment->patient_name ?? '-' }}</td>
                            @else
                                <td>{{ $appointment->location_name ?? '-' }}</td>
                            @endif

                            @can('doctor-access')
                                   <td>{{ $appointment->service ?? '-' }}</td>
                                <td>{{ $appointment->specialty ?? '-' }}</td>
                            @endcan



                            <td>{{ $appointmentTypeOptions[$appointment->type] ?? '-' }}</td>
                            <td>{{ $appointment->day_at ?? '-' }}</td>
                            <td>{{ optional($appointment->start_at)->format('H:i') ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $this->confirmedAppointments->links('components.core.pagination') }}
    @else
        <div class="table__footer">
            <h2>@lang('tables.appointments.not_found')</h2>
        </div>
    @endif
</div>

@script
    <script>
        Livewire.on('open-google-map', url => {
            window.open(url, '_blank');
        });
    </script>
@endscript
