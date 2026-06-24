<div class="table__container" x-on:update-medical-exams-table.window="$wire.$refresh()">
    {{-- Header --}}
    <div class="table__header">
        <h3>@lang('tables.medical_exams.info')</h3>

        <div class="table__header__actions">
            <x-core.button icon="filter" rounded=true hasTooltip=true :tooltip="__('toolTips.common.filters')" :extraClasses="['table__filters__btn']" />
            <x-core.form.selector htmlId="PV-per-page" model="perPage" :data="$perPageOptions" type="filter"
                :tooltip="__('toolTips.common.per_page')" />
        </div>
    </div>

    {{-- Filters --}}
    <div class="table__filters" wire:ignore>
        <div class="form__container">
            <form class="form">

                @if(!$patientId)
                <div class="row">
                    <x-core.form.input html_id="PV-patient" model="patient" :label="__('tables.medical_exams.patient')" type="text"
                        role="filter" />
                    <x-core.form.input html_id="PV-patient-code" model="patientCode" :label="__('tables.medical_exams.patient_code')" type="text"
                        role="filter" />
                </div>
                @endIf

                <div class="row">
                    <x-core.form.selector htmlId="PV-doctor" model="specialtyId" :label="__('tables.medical_exams.specialty')" :data="$specialtiesOptions"
                        type="filter" />
                    <x-core.form.selector htmlId="PV-doctor" model="doctorId" :label="__('tables.medical_exams.doctor')" :data="$doctorsOptions"
                        type="filter" />

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
    @if (isset($this->medicalExams) && $this->medicalExams->count())
        <div class="table__body">
            <table class="table">
                <thead>
                    <tr>
                        <th>@lang('tables.common.actions')</th>

                        <x-core.table.sortable-th model="patient_code" :label="__('tables.medical_exams.patient_code')" :$sortDirection :$sortBy />

                        <x-core.table.sortable-th model="patient_name" :label="__('tables.medical_exams.patient')" :$sortDirection :$sortBy />
                        <x-core.table.sortable-th model="patient_tel" :label="__('tables.medical_exams.patient_tel')" :$sortDirection :$sortBy />

                        <x-core.table.sortable-th model="specialty" :label="__('tables.medical_exams.specialty')" :$sortDirection :$sortBy />
                        <x-core.table.sortable-th model="doctor_name" :label="__('tables.medical_exams.doctor')" :$sortDirection :$sortBy />

                        <x-core.table.sortable-th model="created_at" :label="__('tables.medical_exams.created_at')" :$sortDirection :$sortBy />
                    </tr>
                </thead>

                <tbody>
                    @foreach ($this->medicalExams as $exam)
                        <tr wire:key="visit-{{ $exam->id }}">
                            <td>
                                <x-core.button variant="danger" icon="delete" function="openDeleteDialog"
                                    :parameters="[$exam]" rounded=true hasTooltip=true :tooltip="__('toolTips.medical_exam.delete')" />

                                <livewire:core.open-modal-button
                                wire:key="visit-modal-{{ $exam->id }}"
                                    variant="primary"
                                    icon="edit"
                                    rounded=true
                                     hasTooltip=true
                                     :tooltip="__('toolTips.medical_exam.update')"
                              modalTitle="modals.medical_exam.actions.update"
                                    :modalTitleOptions="[
                                        'code' => $exam->patient_code,
                                        'name'=>$exam->patient_name
                                    ]"
                                    :modalContent="[
                                        'name' => 'app.doctor.medical-exam-modal',
                                        'parameters' => [
                                            'id' => $exam->id,
                                        ],
                                    ]"
                                    :containsTinyMce="true"
                                    />

                                <livewire:core.open-modal-button wire:key="Pv-FM-{{ $exam->id }}" variant="info"
                                    icon="pdf" rounded=true hasTooltip=true :tooltip="__('toolTips.medical_exam.manage.files')"
                                    modalTitle="modals.medical_exam.actions.manage.files" :modalTitleOptions="['name' => $exam->patient_name]"
                                    :modalContent="[
                                        'name' => 'core.files-modal',
                                        'parameters' => [
                                            'fileableId' => $exam->id,
                                            'fileableType' => 'App\Models\MedicalExam',
                                        ],
                                    ]" />

                                <livewire:core.open-modal-button wire:key="Pv-IM-{{ $exam->id }}" variant="info"
                                    icon="images" rounded=true hasTooltip=true :tooltip="__('toolTips.medical_exam.manage.images')"
                                    modalTitle="modals.medical_exam.actions.manage.images" :modalTitleOptions="['name' => $exam->patient_name]"
                                    :modalContent="[
                                        'name' => 'core.images-modal',
                                        'parameters' => [
                                            'imageableId' => $exam->id,
                                            'imageableType' => 'App\Models\MedicalExam',
                                        ],
                                    ]" />
                            </td>
                            <td>{{ $exam->patient_code }}</td>
                            <td>{{ $exam->patient_name }}</td>
                            <td>{{ $exam->patient_tel }}</td>
                            <td>{{ $exam->specialty }}</td>

                            <td>{{ $exam->doctor_name }}</td>

                            <td>{{ $exam->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $this->medicalExams->links('components.core.pagination') }}
    @else
        <div class="table__footer">
            <h2>@lang('tables.medical_exams.not_found')</h2>
        </div>
    @endif
</div>
