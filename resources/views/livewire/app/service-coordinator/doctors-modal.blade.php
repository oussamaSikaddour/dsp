<div class="modal__body__content">

    <div class="form__container">
        <form class="form" wire:submit="handleSubmit">

            <div class="row center">
                <x-core.form.selector
                    htmlId="doctor-mf-id"
                    model="manageForm.user_id"
                    :label="__('forms.doctor.user_id')"
                    :data="$personalOptions"
                    :showError="true"
                />
            </div>

            <div class="form__actions">
                <x-core.button
                    type="submit"
                    icon="confirm"
                    variant="primary"
                    :text="__('forms.common.actions.submit')"
                    :wireTargets="['handleSubmit']"
                    expectLoading="true"
                    fullWidth="true"
                />
            </div>

        </form>
    </div>

    <div
        class="table__container"
        x-on:update-doctors-table.window="$wire.$refresh()"
    >

        @if ($this->doctors->isNotEmpty())

            <div class="table__body">
                <table class="table">

                    <thead>
                        <tr>
                            <th>
                                <div>@lang('tables.common.actions')</div>
                            </th>

                            <x-core.table.sortable-th
                                model="name"
                                :label="__('tables.doctors.name')"
                                :$sortDirection
                                :$sortBy
                            />

                            <x-core.table.sortable-th
                                model="email"
                                :label="__('tables.doctors.email')"
                                :$sortDirection
                                :$sortBy
                            />
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($this->doctors as $doctor)

                            <tr wire:key="doctor-{{ $doctor->id }}">

                                <td>
                                    <x-core.button
                                        variant="danger"
                                        icon="ban"
                                        function="openManageDoctorDialog"
                                        :parameters="[$doctor]"
                                        rounded=true
                                        hasTooltip=true
                                        :tooltip="__('toolTips.coordinator.detach.doctor')"
                                    />
                                </td>

                                <td>{{ $doctor->name }}</td>

                                <td>{{ $doctor->email }}</td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>
            </div>

        @else

            <div class="table__footer">
                <h2>@lang('tables.doctors.not_found')</h2>
            </div>

        @endif

    </div>

</div>
