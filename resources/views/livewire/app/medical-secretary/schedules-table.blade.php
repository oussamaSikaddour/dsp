<div class="table__container" x-on:update-schedules-table.window="$wire.$refresh()">

    {{-- Header --}}
    <div class="table__header">
        <h3>@lang('tables.schedules.info')</h3>

        <div class="table__header__actions">

            {{-- Filters --}}
            <x-core.button icon="filter" rounded=true hasTooltip=true :tooltip="__('toolTips.common.filters')" :extraClasses="['table__filters__btn']" />

            {{-- Per Page --}}
            <x-core.form.selector htmlId="SCH-upp" model="perPage" :data="$perPageOptions" type="filter" :tooltip="__('toolTips.common.per_page')" />

        </div>
    </div>

    {{-- Filters --}}
    <div class="table__filters" wire:ignore>
        <div class="form__container">
            <form class="form">

                <div class="row">
                    <x-core.form.input html_id="SCH-name" model="name" :label="__('tables.schedules.name')" type="text"
                        role="filter" />

                    <x-core.form.selector htmlId="SCH-state" model="state" :label="__('tables.schedules.state')" :data="$statesOptions"
                        type="filter" />
                </div>

                <div class="row">
                    <x-core.form.selector htmlId="SCH-year" model="year" :label="__('tables.schedules.year')" :data="$yearsOptions"
                        type="filter" />

                    <x-core.form.selector htmlId="SCH-month" model="month" :label="__('tables.schedules.month')" :data="$monthsOptions"
                        type="filter" />
                </div>

                <div class="form__actions">
                    <x-core.button type="submit" variant="primary" function="resetFilters" prevent=true rounded=true
                        icon="refresh" hasTooltip=true :tooltip="__('toolTips.common.resetFilters')" />
                </div>

            </form>
        </div>
    </div>

    {{-- Table --}}
    @if ($this->schedules->isNotEmpty())
        <div class="table__body">
            <table class="table">
                <thead>
                    <tr>

                        <th>
                            @lang('tables.common.actions')
                        </th>

                        <x-core.table.sortable-th wire:key="scheduleTH-1" model="name_fr" :label="__('tables.schedules.name_fr')"
                            :$sortDirection :$sortBy />

                        <x-core.table.sortable-th wire:key="scheduleTH-2" model="name_en" :label="__('tables.schedules.name_en')"
                            :$sortDirection :$sortBy />

                        <x-core.table.sortable-th wire:key="scheduleTH-3" model="name_ar" :label="__('tables.schedules.name_ar')"
                            :$sortDirection :$sortBy />

                        <x-core.table.sortable-th wire:key="scheduleTH-4" model="year" :label="__('tables.schedules.year')"
                            :$sortDirection :$sortBy />

                        <x-core.table.sortable-th wire:key="scheduleTH-5" model="month" :label="__('tables.schedules.month')"
                            :$sortDirection :$sortBy />

                        <x-core.table.sortable-th wire:key="scheduleTH-6" model="state" :label="__('tables.schedules.state')"
                            :$sortDirection :$sortBy />

                        <x-core.table.sortable-th wire:key="scheduleTH-7" model="created_at" :label="__('tables.schedules.created_at')"
                            :$sortDirection :$sortBy />

                    </tr>
                </thead>

                <tbody>
                    @foreach ($this->schedules as $schedule)
                        @php
                            $name = $schedule->{'name_' . $locale};
                        @endphp

                        <tr wire:key="schedule-{{ $schedule->id }}">
                            <td>

                                @if ($schedule->state === 'not_published')
                                    @if (!$schedule->locked)
                                        <x-core.button variant="danger" icon="delete" function="openDeleteDialog"
                                            :parameters="[$schedule]" rounded=true hasTooltip=true :tooltip="__('toolTips.schedule.delete')" />


                                        <livewire:core.open-modal-button wire:key="edit-schedule-{{ $schedule->id }}"
                                            rounded=true hasTooltip=true :tooltip="__('toolTips.schedule.update')" icon="edit"
                                            modalTitle="modals.schedule.actions.update" :modalContent="[
                                                'name' => 'app.medical-secretary.schedule-modal',
                                                'parameters' => [
                                                    'scheduleId' => $schedule->id,
                                                ],
                                            ]" />
                                    @endif

                                    <x-core.button variant="info" icon="upload" function="openPublishDialog"
                                        :parameters="[$schedule]" rounded=true hasTooltip=true :tooltip="__('toolTips.schedule.publish')" />
                                @endif


                                <x-core.button icon="view" variant="info" route="manage_schedule_route"
                                    :routeParameters="[
                                        'id' => $schedule->id,
                                    ]" rounded=true hasTooltip=true :tooltip="__('toolTips.schedule.manage.view')" />

                            </td>

                            <td>{{ $schedule->name_fr }}</td>
                            <td>{{ $schedule->name_en }}</td>
                            <td>{{ $schedule->name_ar }}</td>

                            <td>
                                {{ $yearsOptions[$schedule->year] ?? $schedule->year }}
                            </td>

                            <td>
                                {{ $monthsOptions[$schedule->month] ?? $schedule->month }}
                            </td>

                            <td>
                                {{ $statesOptions[$schedule->state] ?? $schedule->state }}
                            </td>

                            <td>
                                {{ $schedule->created_at->format('d-m-Y') }}
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $this->schedules->links('components.core.pagination') }}
    @else
        <div class="table__footer">
            <h2>@lang('tables.schedules.not_found')</h2>
        </div>
    @endif

</div>
