<div class="table__container" x-on:update-patients-table.window="$wire.$refresh()">

    <div class="table__header">

        <h3>{{ $patientsTableInfoText }}</h3>

        <div class="table__header__actions">

            <x-core.button icon="filter" rounded=true hasTooltip=true :tooltip="__('toolTips.common.filters')" :extraClasses="['table__filters__btn']" />

            <x-core.form.selector htmlId="PAT-pp" model="perPage" :data="$perPageOptions" type="filter" :tooltip="__('toolTips.common.per_page')" />

        </div>

    </div>

    <div class="table__filters" wire:ignore>

        <div class="form__container">

            <form class="form">

                <div class="row">

                    <x-core.form.input html_id="PAT-code" model="code" :label="__('tables.patients.code')" role="filter" />

                    <x-core.form.input html_id="PAT-name" model="name" :label="__('tables.patients.name')" role="filter" />

                </div>

                <div class="row">

                    <x-core.form.selector htmlId="PAT-gender" model="gender" :label="__('tables.patients.gender')" :data="$genderOptions"
                        type="filter" />

                    <x-core.form.input html_id="PAT-tel" model="tel" :label="__('tables.patients.tel')" role="filter" />

                </div>

                <div class="row">

                    <x-core.form.selector htmlId="PAT-commune" model="communeId" :label="__('tables.patients.commune')" :data="$communesOptions"
                        type="filter" />

                </div>

                <div class="form__actions">

                    <x-core.button type="submit" variant="primary" function="resetFilters" prevent=true rounded=true
                        icon="refresh" hasTooltip=true :tooltip="__('toolTips.common.resetFilters')" />

                </div>

            </form>

        </div>

    </div>

    @if ($this->patients->isNotEmpty())

        <div class="table__body">

            <table class="table">

                <thead>

                    <tr>

                        <th>@lang('tables.common.actions')</th>

                        <x-core.table.sortable-th model="code" :label="__('tables.patients.code')" :$sortDirection :$sortBy />

                        <x-core.table.sortable-th model="first_name_fr" :label="__('tables.patients.full_name')" :$sortDirection :$sortBy />

                        <x-core.table.sortable-th model="gender" :label="__('tables.patients.gender')" :$sortDirection :$sortBy />

                        <x-core.table.sortable-th model="birth_date" :label="__('tables.patients.birth_date')" :$sortDirection :$sortBy />

                        <th>@lang('tables.patients.commune')</th>

                        <x-core.table.sortable-th model="tel" :label="__('tables.patients.tel')" :$sortDirection :$sortBy />

                        <th>@lang('tables.patients.appointments')</th>

                    </tr>

                </thead>
                <tbody>

                    @php
                        $isRelative = !$isForServicePersonnel;

                        $ui = [
                            'viewTooltip' => $isRelative
                                ? 'toolTips.patient.view.relative'
                                : 'toolTips.patient.view.patient',

                            'deleteTooltip' => $isRelative
                                ? 'toolTips.patient.delete.relative'
                                : 'toolTips.patient.delete.patient',

                            'updateTooltip' => $isRelative
                                ? 'toolTips.patient.update.relative'
                                : 'toolTips.patient.update.patient',

                            'updateModalTitle' => $isRelative
                                ? 'modals.patient.actions.update.relative'
                                : 'modals.patient.actions.update.patient',
                        ];
                    @endphp


                    @foreach ($this->patients as $patient)
                        <tr wire:key="patient-{{ $patient->id }}">

                            {{-- ACTIONS --}}
                            <td class="table__actions">

                                {{-- VIEW --}}

                                         @can('doctor-access')
                                      <x-core.button icon="visit" variant="info" route="medical_exams_route"
                                        :routeParameters="[
                                            'id' => $patient->id,
                                        ]" rounded hasTooltip :tooltip="__('toolTips.patient.view.exam')" />
                                 @endcan

                                @if($isForServicePersonnel)
                                    <livewire:core.open-modal-button
                                    variant="success"
                                     wire:key="book-second-appointment-{{ $patient->id }}"
                                    icon="book" rounded
                                    modalTitle='modals.appointment.actions.follow-up'
                                    :modalTitleOptions="[
                                        'name' => $patient->localized_full_name,
                                        'code' => $patient->code,
                                    ]" :modalContent="[
                                        'name' => 'app.book-slot-modal',
                                        'parameters' => [
                                            'patientId' => $patient->id,
                                            'appointmentType'=>'follow-up'
                                        ],
                                    ]"
                                    hasTooltip :tooltip="__('toolTips.appointment.follow-up')" />


                                    @if($patient->auto_generated)
                                <x-core.button variant="primary" icon="print"
                                    function="generatePatientPdf" :parameters="[$patient]" rounded=true
                                    hasTooltip=true :tooltip="__('toolTips.patient.print_opened_by')" />
                                    @endif

                                @else
                                <x-core.button icon="book" variant="info" route="patient_route" :routeParameters="['id' => $patient->id, 'isForServicePersonnel'=>$isForServicePersonnel]"
                                    rounded hasTooltip :tooltip="__($ui['viewTooltip'])" />

                              @endif
                                {{-- EDIT --}}

                                @if($patient->auto_generated || !$isForServicePersonnel )
                                <livewire:core.open-modal-button wire:key="edit-patient-{{ $patient->id }}"
                                    icon="edit" rounded :modalTitle="$ui['updateModalTitle']" :modalTitleOptions="[
                                        'name' => $patient->localized_full_name,
                                        'code' => $patient->code,
                                    ]" :modalContent="[
                                        'name' => 'app.patient-modal',
                                        'parameters' => [
                                            'patientId' => $patient->id,
                                        ],
                                    ]"
                                    hasTooltip :tooltip="__($ui['updateTooltip'])" />

                                {{-- DELETE --}}
                                <x-core.button variant="danger" icon="delete" function="openDeleteDialog"
                                    :parameters="[$patient]" rounded hasTooltip :tooltip="__($ui['deleteTooltip'])" />
                                @endif

                            </td>


                            <td>{{ $patient->code }}</td>

                            {{-- FULL NAME --}}
                            <td>{{ $patient->localized_full_name }}</td>

                            {{-- GENDER --}}
                            <td>
                                {{ $genderOptions[$patient->gender] ?? $patient->gender  }}
                            </td>

                            {{-- BIRTH DATE --}}
                            <td>
                                {{ $patient->birth_date?->format('d-m-Y') ?? '-' }}
                            </td>

                            {{-- COMMUNE --}}
                            <td>
                                {{ $patient->commune_name ?? '-' }}
                            </td>

                            {{-- PHONE --}}
                            <td>
                                {{ $patient->tel ?? '-' }}
                            </td>

                            {{-- APPOINTMENTS COUNT --}}
                            <td>
                                {{ $patient->appointments_count }}
                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

        {{ $this->patients->links('components.core.pagination') }}
    @else
        <div class="table__footer">
            <h2>{{ $patientsTableNotFoundText }}</h2>
        </div>

    @endif

</div>
