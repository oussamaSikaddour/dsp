<div class="table__container" x-on:update-services-table.window="$wire.$refresh()">

    {{-- Header --}}
    <div class="table__header">
        <h3>@lang('tables.services.info')</h3>

        <div class="table__header__actions">

            {{-- Loading --}}
            <span wire:loading wire:target="excelFile">
                <x-core.loading />
            </span>

            {{-- Upload Excel --}}
            <x-core.file-input
                icon="upload"
                :tooltip="__('toolTips.service.excel.upload')"
                model="excelFile"
                types="excel"
                type="icon_only"
            />

            {{-- Empty Excel --}}
            <x-core.button
                icon="export"
                function="generateEmptyServicesExcel"
                rounded
                hasTooltip
                :tooltip="__('toolTips.service.excel.empty')"
            />

            {{-- Export Excel --}}
            <x-core.button
                icon="export"
                variant="success"
                function="generateServicesExcel"
                rounded
                hasTooltip
                :tooltip="__('toolTips.service.excel.download')"
            />

            {{-- Filters --}}
            <x-core.button
                icon="filter"
                rounded
                hasTooltip
                :tooltip="__('toolTips.common.filters')"
                :extraClasses="['table__filters__btn']"
            />

            {{-- Per Page --}}
            <x-core.form.selector
                htmlId="TS-upp"
                model="perPage"
                :label="__('tables.common.perPage')"
                :data="$perPageOptions"
                type="filter"
                :tooltip="__('toolTips.common.per_page')"
            />

        </div>
    </div>

    {{-- Filters --}}
    <div class="table__filters" wire:ignore>
        <div class="form__container">
            <form class="form">

                <div class="row">
                    <x-core.form.input
                        model="name"
                        :label="__('tables.services.name')"
                        type="text"
                        html_id="TS-Name"
                        role="filter"
                    />

                    <x-core.form.input
                        model="headOfService"
                        :label="__('tables.services.head_service')"
                        type="text"
                        html_id="TS-Head"
                        role="filter"
                    />
                </div>

                <div class="row">
                    <x-core.form.selector
                        htmlId="TS-Type"
                        model="type"
                        :label="__('tables.services.type')"
                        :data="$serviceTypesOptions"
                        type="filter"
                    />

                    <x-core.form.selector
                        htmlId="TS-Specialty"
                        model="specialtyId"
                        :label="__('tables.services.specialty')"
                        :data="$serviceSpecialtiesOptions"
                        type="filter"
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

    {{-- Table --}}
    @if(isset($this->services) && count($this->services))
        <div class="table__body">
            <table class="table">
                <thead>
                    <tr>

                        <th>
                            <div>@lang('tables.common.actions')</div>
                        </th>

                        <x-core.table.sortable-th
                            wire:key="service-th-1"
                            model="name_fr"
                            :label="__('tables.services.name_fr')"
                            :$sortDirection
                            :$sortBy
                        />

                        <x-core.table.sortable-th
                            wire:key="service-th-2"
                            model="name_ar"
                            :label="__('tables.services.name_ar')"
                            :$sortDirection
                            :$sortBy
                        />

                        <x-core.table.sortable-th
                            wire:key="service-th-3"
                            model="name_en"
                            :label="__('tables.services.name_en')"
                            :$sortDirection
                            :$sortBy
                        />

                        <x-core.table.sortable-th
                            wire:key="service-th-4"
                            model="head_service"
                            :label="__('tables.services.head_service')"
                            :$sortDirection
                            :$sortBy
                        />

                        <x-core.table.sortable-th
                            wire:key="service-th-5"
                            model="type"
                            :label="__('tables.services.type')"
                            :$sortDirection
                            :$sortBy
                        />

                        <x-core.table.sortable-th
                            wire:key="service-th-6"
                            model="specialty"
                            :label="__('tables.services.specialty')"
                            :$sortDirection
                            :$sortBy
                        />

                        <x-core.table.sortable-th
                            wire:key="service-th-7"
                            model="tel"
                            :label="__('tables.services.tel')"
                            :$sortDirection
                            :$sortBy
                        />

                        <x-core.table.sortable-th
                            wire:key="service-th-8"
                            model="fax"
                            :label="__('tables.services.fax')"
                            :$sortDirection
                            :$sortBy
                        />

                        <x-core.table.sortable-th
                            wire:key="service-th-9"
                            model="created_at"
                            :label="__('tables.services.created_at')"
                            :$sortDirection
                            :$sortBy
                        />

                    </tr>
                </thead>

                <tbody>
                    @foreach ($this->services as $service)
                        <tr wire:key="{{ $service->id }}-service">
                            <td>

                                <x-core.button
                                    variant="danger"
                                    icon="delete"
                                    function="openDeleteDialog"
                                    :parameters="[$service]"
                                    rounded=true
                                    hasTooltip=true
                                    :tooltip="__('toolTips.service.delete')"
                                />

                                <livewire:core.open-modal-button
                                    wire:key="edit-service-{{ $service->id }}"
                                    rounded=true
                                    hasTooltip=true
                                    :tooltip="__('toolTips.service.update')"
                                    icon="edit"
                                    modalTitle="modals.service.actions.update"
                                    :modalTitleOptions="[
                                        'name' => $service->localized_name
                                    ]"
                                    :modalContent="[
                                        'name' => 'app.establishment-admin.service-modal',
                                        'parameters' => [
                                            'id' => $service->id,
                                            'establishmentId' => $service->establishment_id,
                                        ],
                                    ]"
                                    containsTinyMce=true
                                />

                                <livewire:core.open-modal-button
                                    wire:key="service-coordinators-{{ $service->id }}"
                                    rounded=true
                                    hasTooltip=true
                                    :tooltip="__('toolTips.service.manage.coordinators')"
                                    icon="users"
                                    modalTitle="modals.service.actions.manage_coordinators"
                                    :modalTitleOptions="[
                                        'name' => $service->localized_name
                                    ]"
                                    :modalContent="[
                                        'name' => 'app.establishment-admin.coordinators-modal',
                                        'parameters' => [
                                            'serviceId' => $service->id,
                                            'establishmentId' => $service->establishment_id,
                                        ],
                                    ]"
                                />

                            </td>

                            <td>{{ $service->name_fr }}</td>
                            <td>{{ $service->name_ar }}</td>
                            <td>{{ $service->name_en }}</td>
                            <td>{{ $service->head_service }}</td>
                            <td>{{ $serviceTypesOptions[$service->type] ?? '-' }}</td>
                            <td>{{ $service->specialty }}</td>
                            <td>{{ $service->tel }}</td>
                            <td>{{ $service->fax }}</td>
                            <td>{{ $service->created_at->format('d-m-Y') }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $this->services->links('components.core.pagination') }}

    @else
        <div class="table__footer">
            <h2>@lang('tables.services.not_found')</h2>
        </div>
    @endif

</div>
