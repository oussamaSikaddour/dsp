<div class="table__container" x-on:update-schedule-days-table.window="$wire.$refresh()">

    <div class="table__header">

        <h3>
            @lang('tables.schedule_days.info')
        </h3>

        <div class="table__header__actions">

            @if ($showGenerateSlotsForAllButton)
                <x-core.button variant="danger" icon="settings" function="openGenerateSlotsForAllDialog" rounded=true
                    hasTooltip=true :tooltip="__('toolTips.schedule_day.generate.for_all')" />
            @endif

            <x-core.button icon="filter" rounded=true hasTooltip=true :tooltip="__('toolTips.common.filters')" :extraClasses="['table__filters__btn']" />

            <x-core.form.selector htmlId="SD-pp" model="perPage" :data="$perPageOptions" type="filter" :tooltip="__('toolTips.common.per_page')" />

        </div>

    </div>

    <div class="table__filters" wire:ignore>

        <div class="form__container">

            <form class="form">

                <div class="row">

                    <x-core.form.input html_id="SD-dayAt" model="dayAt" type="date" :label="__('tables.schedule_days.day_at')"
                        role="filter" />

                    <x-core.form.input html_id="SD-duration" model="appointmentDuration" type="number"
                        :label="__('tables.schedule_days.appointment_duration')" role="filter" />

                </div>

                <div class="form__actions">

                    <x-core.button type="submit" variant="primary" function="resetFilters" prevent=true rounded=true
                        icon="refresh" hasTooltip=true :tooltip="__('toolTips.common.resetFilters')" />

                </div>

            </form>

        </div>

    </div>

    @if ($this->scheduleDays->isNotEmpty())

        <div class="table__body">

            <table class="table">

                <thead>

                    <tr>

                        <th>
                            @lang('tables.common.actions')
                        </th>

                        <x-core.table.sortable-th model="day_at" :label="__('tables.schedule_days.day_at')" :sortDirection="$sortDirection"
                            :sortBy="$sortBy" />

                        <x-core.table.sortable-th model="appointment_duration" :label="__('tables.schedule_days.appointment_duration')" :sortDirection="$sortDirection"
                            :sortBy="$sortBy" />

                        <th>
                            @lang('tables.schedule_days.slots')
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach ($this->scheduleDays as $scheduleDay)
                        <tr wire:key="schedule-day-row-{{ $scheduleDay->id }}">

                            @php
                                $date_at = $scheduleDay->day_at->format('Y-m-d');
                            @endphp
                            <td>

                                @if ($schedule->state === 'not_published' && !$scheduleDay->locked)
                                    <x-core.button variant="danger" icon="delete" function="openDeleteDialog"
                                        :parameters="[$scheduleDay]" rounded=true hasTooltip=true :tooltip="__('toolTips.schedule_day.delete')" />

                                    <livewire:core.open-modal-button wire:key="edit-schedule-day-{{ $scheduleDay->id }}"
                                        rounded=true hasTooltip=true :tooltip="__('toolTips.schedule_day.update')" icon="edit"
                                        modalTitle="modals.schedule_day.actions.update" :modalTitleOptions="['date' => $date_at]"
                                        :modalContent="[
                                            'name' => 'app.medical-secretary.schedule-day-modal',
                                            'parameters' => [
                                                'scheduleDayId' => $scheduleDay->id,
                                            ],
                                        ]" />


                                    <x-core.button variant="success" icon="setting"
                                        function="openGenerateSlotsForOneDialog" :parameters="[$scheduleDay]" rounded=true
                                        hasTooltip=true :tooltip="__('toolTips.schedule_day.generate.for_one')" />
                                @endif

                                <livewire:core.open-modal-button wire:key="view-schedule-day-{{ $scheduleDay->id }}"
                                    rounded=true hasTooltip=true :tooltip="__('toolTips.schedule_day.view')" icon="view" variant="info"
                                    :modalTitleOptions="['date' => $date_at]" modalTitle="modals.schedule_day.actions.view"
                                    :modalContent="[
                                        'name' => 'app.medical-secretary.schedule-slots-table-modal',
                                        'parameters' => [
                                            'scheduleDayId' => $scheduleDay->id,
                                        ],
                                    ]" />

                            </td>

                            <td>
                                {{ $date_at }}
                            </td>

                            <td>
                                {{ $scheduleDay->appointment_duration }}
                            </td>

                            <td>
                                {{ $scheduleDay->slots_count }}
                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

        {{ $this->scheduleDays->links('components.core.pagination') }}
    @else
        <div class="table__footer">

            <h2>
                @lang('tables.schedule_days.not_found')
            </h2>

        </div>

    @endif

</div>
