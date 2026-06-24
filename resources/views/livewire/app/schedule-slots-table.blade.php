<div
    class="table__container"
    x-on:update-schedule-slots-table.window="$wire.$refresh()"
>
    {{-- HEADER --}}
    <div class="table__header">

        <h3>
            @lang('tables.schedule_slots.info', ['date' => $scheduleDayDate])
        </h3>

        <div class="table__header__actions">

            {{-- Filters toggle --}}
            <x-core.button
                icon="filter"
                rounded=true
                hasTooltip=true
                :tooltip="__('toolTips.common.filters')"
                :extraClasses="['table__filters__btn']"
            />

            {{-- Per page --}}
            <x-core.form.selector
                htmlId="SS-pp"
                model="perPage"
                :data="$perPageOptions"
                type="filter"
                :tooltip="__('toolTips.common.per_page')"
            />

        </div>
    </div>

    {{-- FILTERS --}}
    <div class="table__filters" wire:ignore.self>

        <div class="form__container">

            <form class="form">

                <div class="row">

                    <x-core.form.input
                        html_id="SS-start"
                        model="startAt"
                        type="time"
                        :label="__('tables.schedule_slots.start_at')"
                        role="filter"
                    />

                    <x-core.form.input
                        html_id="SS-end"
                        model="endAt"
                        type="time"
                        :label="__('tables.schedule_slots.end_at')"
                        role="filter"
                    />

                </div>

                <div class="form__actions">

                    <x-core.button
                        type="submit"
                        variant="primary"
                        function="resetFilters"
                        prevent=true
                        rounded=true
                        icon="refresh"
                        hasTooltip=true
                        :tooltip="__('toolTips.common.resetFilters')"
                    />

                </div>

            </form>

        </div>

    </div>

    {{-- TABLE --}}
    @if ($this->scheduleSlots->isNotEmpty())

        <div class="table__body">

            <table class="table">

                <thead>

                    <tr>

                        <th>
                            @lang('tables.common.actions')
                        </th>

                        <x-core.table.sortable-th
                            model="start_at"
                            :label="__('tables.schedule_slots.start_at')"
                            :$sortDirection
                            :$sortBy
                        />

                        <x-core.table.sortable-th
                            model="end_at"
                            :label="__('tables.schedule_slots.end_at')"
                            :$sortDirection
                            :$sortBy
                        />

                        <x-core.table.sortable-th
                            model="status"
                            :label="__('tables.schedule_slots.status')"
                            :$sortDirection
                            :$sortBy
                        />

                        <x-core.table.sortable-th
                            model="day_at"
                            :label="__('tables.schedule_slots.day_at')"
                            :$sortDirection
                            :$sortBy
                        />

                        <x-core.table.sortable-th
                            model="specialty"
                            :label="__('tables.schedule_slots.specialty')"
                            :$sortDirection
                            :$sortBy
                        />

                        <x-core.table.sortable-th
                            model="appointments_location"
                            :label="__('tables.schedule_slots.appointments_location')"
                            :$sortDirection
                            :$sortBy
                        />

                    </tr>

                </thead>

                <tbody>

                    @foreach ($this->scheduleSlots as $slot)

                        <tr wire:key="slot-{{ $slot->id }}">

                            {{-- ACTIONS --}}
                            <td>

                                @if ($slot->status === 'available')

                                    <x-core.button
                                        variant="danger"
                                        icon="lock"
                                        function="openBlockDialog"
                                        :parameters="[$slot->id]"
                                        rounded=true
                                        hasTooltip=true
                                        :tooltip="__('toolTips.schedule_slot.block')"
                                    />

                                @elseif ($slot->status === 'blocked')

                                    <x-core.button
                                        variant="success"
                                        icon="unlock"
                                        function="openUnblockDialog"
                                        :parameters="[$slot->id]"
                                        rounded=true
                                        hasTooltip=true
                                        :tooltip="__('toolTips.schedule_slot.unblock')"
                                    />

                                @endif

                            </td>

                            {{-- TIME --}}
                            <td>
                                {{ $slot->start_at }}
                            </td>

                            <td>
                                {{ $slot->end_at }}
                            </td>

                            {{-- STATUS --}}
                            <td>
                                {{ $statusOptions[$slot->status] }}
                            </td>

                            {{-- DATE --}}
                            <td>
                                {{ $slot->day_at }}
                            </td>

                            {{-- SPECIALTY --}}
                            <td>
                                {{ $slot->specialty ?? '-' }}
                            </td>

                            {{-- LOCATION --}}
                            <td>
                                {{ $slot->appointments_location ?? '-' }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        {{ $this->scheduleSlots->links('components.core.pagination') }}

    @else

        <div class="table__footer">

            <h2>
                @lang('tables.schedule_slots.not_found')
            </h2>

        </div>

    @endif

</div>
