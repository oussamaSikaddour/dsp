<div class="modal__body__content">

    <div class="form__container">
        <form class="form" wire:submit="handleSubmit">

            <div class="row center">
                <x-core.form.selector
                    htmlId="medical-secretary-mf-id"
                    model="manageForm.user_id"
                    :label="__('forms.medical_secretary.user_id')"
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
        x-on:update-medical-secretaries-table.window="$wire.$refresh()"
    >

        @if ($this->secretaries->isNotEmpty())

            <div class="table__body">
                <table class="table">

                    <thead>
                        <tr>
                            <th>
                                <div>@lang('tables.common.actions')</div>
                            </th>

                            <x-core.table.sortable-th
                                model="name"
                                :label="__('tables.medical_secretaries.name')"
                                :$sortDirection
                                :$sortBy
                            />

                            <x-core.table.sortable-th
                                model="email"
                                :label="__('tables.medical_secretaries.email')"
                                :$sortDirection
                                :$sortBy
                            />
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($this->secretaries as $secretary)

                            <tr wire:key="secretary-{{ $secretary->id }}">

                                <td>
                                    <x-core.button
                                        variant="danger"
                                        icon="ban"
                                        function="openManageSecretaryDialog"
                                        :parameters="[$secretary]"
                                        rounded=true
                                        hasTooltip=true
                                        :tooltip="__('toolTips.coordinator.detach.medical_secretary')"
                                    />
                                </td>

                                <td>{{ $secretary->name }}</td>

                                <td>{{ $secretary->email }}</td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>
            </div>

        @else

            <div class="table__footer">
                <h2>@lang('tables.medical_secretaries.not_found')</h2>
            </div>

        @endif

    </div>

</div>
