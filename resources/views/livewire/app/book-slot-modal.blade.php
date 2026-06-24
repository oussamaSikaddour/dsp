<div class="modal__body__content">

    <!-- Form Section -->
    <form class="table__form">
        <div class="table__form__inputs">

            <div class="column center">
                <h3 style="text-align: center">@lang('forms.appointment.information.title')</h3>
            </div>

            <div class="row">
                <div class="column">
                    <p style="text-align: center">@lang('forms.appointment.information.specialty') :</p>

                    <x-core.form.selector htmlId="SS-specialty" model="bookForm.specialty_id" :label="__('forms.appointment.specialty_id')"
                        :data="$specialtiesOptions" type="filter" />
                </div>


                @if($appointmentType=="initial")
                <div class="column">
                    <p style="text-align: center">@lang('forms.appointment.information.referral_letter') :</p>
                    <div class="column center" x-data="{
                        uploading: false,
                        progress: 0
                    }" x-on:livewire-upload-start="uploading = true"
                        x-on:livewire-upload-finish="uploading = false" x-on:livewire-upload-error="uploading = false"
                        x-on:livewire-upload-progress="progress = $event.detail.progress" wire:ignore.self>

                        <x-core.file-input model="bookForm.referral_letter" types="img" type="image"
                            :fileUri="$temporaryImageUrl" :tooltip="__('forms.appointment.referral_letter')" />

                        <template x-if="uploading">
                            <div class="upload__progress">
                                <progress max="100" x-bind:value="progress"></progress>
                            </div>
                        </template>

                    </div>
                </div>
                @endIf
            </div>
        </div>
    </form>

    <!-- Table Section -->
    <div class="table__container">

        <div class="table__header">
            <h3>@lang('tables.schedule_slots.info', ['date' => $scheduleDayDate])</h3>

            <div class="table__header__actions">
                <span wire:loading wire:target="excelFile">
                    <x-core.loading />
                </span>

                <x-core.button icon="list" variant="info" rounded="true" hasTooltip="true" :tooltip="__('tooltips.schedule_slot.options.expand')"
                    :extraClasses="['table__filters__btn']" />

                <x-core.form.selector htmlId="SS-pp" model="perPage" :data="$perPageOptions" type="filter"
                    :tooltip="__('toolTips.common.per_page')" />
            </div>
        </div>

        <div class="table__filters" wire:ignore.self>
            <div class="form__container">
                <form class="form">

                    <div class="row">
                        <x-core.form.selector htmlId="SS-date" model="scheduleDayDate" :label="__('tables.schedule_slots.day_at')"
                            :data="$scheduleDaysOptions ?? []" type="filter" />

                        <x-core.form.selector htmlId="SS-daira" model="dairaId" :label="__('tables.schedule_slots.daira')" :data="$dairatesOptions"
                            type="filter" />

                        <x-core.form.selector htmlId="SS-location" model="appointmentsLocationId" :label="__('tables.schedule_slots.appointments_location')"
                            :data="$appointmentsLocationsOptions" type="filter" />
                    </div>

                    <div class="row">
                        <x-core.form.input html_id="SS-start" model="startAt" type="time" :label="__('tables.schedule_slots.start_at')"
                            role="filter" />

                        <x-core.form.input html_id="SS-end" model="endAt" type="time" :label="__('tables.schedule_slots.end_at')"
                            role="filter" />
                    </div>

                    <div class="row">
                        <x-core.button hasTooltip="true" :tooltip="__('tooltips.schedule_slot.options.reset')" type="submit" variant="info"
                            function="resetFilters" prevent="true" rounded="true" icon="refresh" />
                    </div>

                </form>
            </div>
        </div>

        @if (isset($this->scheduleSlots) && $this->scheduleSlots->isNotEmpty())

            <div class="table__body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>
                                <div>@lang('tables.common.actions')</div>
                            </th>
                            <th>@lang('tables.schedule_slots.day_at')</th>
                            <th>@lang('tables.schedule_slots.start_at')</th>
                            <th>@lang('tables.schedule_slots.end_at')</th>

                            <th>@lang('tables.schedule_slots.specialty')</th>
                            <th>@lang('tables.schedule_slots.daira')</th>
                            <th>@lang('tables.schedule_slots.appointments_location')</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($this->scheduleSlots as $slot)
                            <tr wire:key="slot-{{ $slot->id }}">

                                <td>
                                    <x-core.button variant="success" icon="book" function="openBookDialog"
                                        :parameters="[$slot->id]" rounded="true" hasTooltip="true" :tooltip="__('toolTips.schedule_slot.book')" />
                                </td>
                                <td>{{ $slot->day_at }}</td>
                                <td>{{ optional($slot->start_at)->format('H:i') ?? '-' }}</td>
                                <td>{{ optional($slot->end_at)->format('H:i') ?? '-' }}</td>

                                <td>{{ $slot->specialty ?? '-' }}</td>
                                <td>{{ $slot->daira ?? '-' }}</td>
                                <td>{{ $slot->appointments_location ?? '-' }}</td>

                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

            {{ $this->scheduleSlots->links('components.core.pagination') }}
        @else
            <div class="table__footer">
                <h2>@lang('tables.schedule_slots.not_found')</h2>
            </div>
        @endif

    </div>
</div>
