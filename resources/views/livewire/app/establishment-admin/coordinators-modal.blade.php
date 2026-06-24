<div class="modal__body__content">

    {{-- Add Coordinator Form --}}
    <div class="form__container">
        <form class="form" wire:submit="handleSubmit">

            <div class="row center">
                <x-core.form.selector
                    htmlId="coord-mf-id"
                    model="manageForm.user_id"
                    :label="__('forms.coordinator.user_id')"
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

    {{-- Coordinators Table --}}
    <div class="table__container"
         x-on:update-coordinators-table.window="$wire.$refresh()">

        @if ($this->coordinators->isNotEmpty())

            <div class="table__body">
                <table class="table">

                    <thead>
                        <tr>
                            <th scope="column">
                                <div>@lang('tables.common.actions')</div>
                            </th>
                            <x-core.table.sortable-th
                                wire:key="coord-TH-2"
                                model="name"
                                :label="__('tables.coordinators.name')"
                                :$sortDirection
                                :$sortBy
                            />
                            <x-core.table.sortable-th
                                wire:key="coord-TH-3"
                                model="email"
                                :label="__('tables.coordinators.email')"
                                :$sortDirection
                                :$sortBy
                            />
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($this->coordinators as $coord)
                            <tr wire:key="coord-{{ $coord->id }}">

                                <td>
                                    <x-core.button
                                        variant="danger"
                                        icon="ban"
                                        function="openManageCoordDialog"
                                        :parameters="[$coord]"
                                        rounded=true
                                        hasTooltip=true
                                        :tooltip="__('toolTips.appointments-location-admin.ban')"
                                    />
                                </td>
                                <td>{{ $coord->name }}</td>
                                <td>{{ $coord->email }}</td>

                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        @else

            <div class="table__footer">
                <h2>@lang('tables.coordinators.not_found')</h2>
            </div>

        @endif

    </div>

</div>
