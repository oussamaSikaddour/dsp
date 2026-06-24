<div class="table__container" x-on:update-establishments-table.window="$wire.$refresh()">
    <div class="table__header">
        <h3>@lang('tables.establishments.info')</h3>

        <div class="table__header__actions">

            {{-- Loading --}}
            <span wire:loading wire:target="excelFile">
                <x-core.loading />
            </span>

            {{-- Upload Excel --}}
            <x-core.file-input icon="upload" :tooltip="__('toolTips.establishment.excel.upload')" model="excelFile" types="excel" type="icon_only" />

            {{-- Empty Excel --}}
            <x-core.button icon="export" function="generateEmptyEstablishmentsExcel" rounded hasTooltip
                :tooltip="__('toolTips.establishment.excel.empty')" />

            {{-- Export Excel --}}
            <x-core.button icon="export" variant="success" function="generateEstablishmentsExcel" rounded hasTooltip
                :tooltip="__('toolTips.establishment.excel.download')" />

            {{-- Filters --}}
            <x-core.button icon="filter" rounded hasTooltip :tooltip="__('toolTips.common.filters')" :extraClasses="['table__filters__btn']" />

            {{-- Per Page --}}
            <x-core.form.selector htmlId="TE-upp" model="perPage" :label="__('tables.common.perPage')" :data="$perPageOptions" type="filter"
                :tooltip="__('toolTips.common.per_page')" />

        </div>
    </div>
    <div class="table__filters" wire:ignore>
        <div class="form__container">
            <form class="form">

                {{-- ROW 1 --}}
                <div class="row">
                    <x-core.form.input model="acronym" :label="__('tables.establishments.acronym')" type="text" html_id="Est-AcronymUT"
                        role="filter" />

                    <x-core.form.input model="name" :label="__('tables.establishments.name')" type="text" html_id="Est-NameUT"
                        role="filter" />
                </div>

                {{-- ROW 2 --}}
                <div class="row">
                    <x-core.form.selector htmlId="Est-DairaUT" model="daira" :label="__('tables.establishments.daira')" :data="$dairasOptions"
                        type="filter" />
                </div>

                {{-- ACTIONS --}}
                <div class="form__actions">
                    <x-core.button hasTooltip=true :tooltip="__('toolTips.common.resetFilters')" type="submit" variant="primary"
                        function="resetFilters" prevent=true rounded=true icon="refresh" />
                </div>

            </form>
        </div>
    </div>

    @if (isset($this->establishments) && count($this->establishments))
        <div class="table__body">
            <table class="table">
                <thead>
                    <tr>

                        <th scope="column">
                            <div>@lang('tables.common.actions')</div>
                        </th>
                        <x-core.table.sortable-th
                        wire:key="est-TH-1"
                        model="acronym"
                        :label="__('tables.establishments.acronym')"
                        :$sortDirection
                            :$sortBy />

                        <x-core.table.sortable-th
                        wire:key="est-TH-2"
                        model="name_fr"
                        :label="__('tables.establishments.name_fr')"
                        :$sortDirection
                            :$sortBy />

                        <x-core.table.sortable-th
                        wire:key="est-TH-8" model="name_ar" :label="__('tables.establishments.name_ar')" :$sortDirection
                            :$sortBy />

                        <x-core.table.sortable-th wire:key="est-TH-9" model="name_en" :label="__('tables.establishments.name_en')" :$sortDirection
                            :$sortBy />

                        <x-core.table.sortable-th wire:key="est-TH-3" model="email" :label="__('tables.establishments.email')" :$sortDirection
                            :$sortBy />

                        <x-core.table.sortable-th wire:key="est-TH-4" model="tel" :label="__('tables.establishments.tel')" :$sortDirection
                            :$sortBy />

                        <x-core.table.sortable-th wire:key="est-TH-5" model="fax" :label="__('tables.establishments.fax')" :$sortDirection
                            :$sortBy />

                        <x-core.table.sortable-th wire:key="est-TH-6" model="daira" :label="__('tables.establishments.daira')" :$sortDirection
                            :$sortBy />

                        <x-core.table.sortable-th wire:key="est-TH-7" model="created_at" :label="__('tables.establishments.created_at')"
                            :$sortDirection :$sortBy />

                    </tr>
                </thead>

                <tbody>
                    @foreach ($this->establishments as $establishment)
                        <tr wire:key="{{ $establishment->id }}-gt">
                            <td>


                                <x-core.button variant="danger" icon="delete" function="openDeleteEstablishmentDialog"
                                    :parameters="[$establishment]" rounded=true hasTooltip=true :tooltip="__('toolTips.establishment.delete')" />


                                  <livewire:core.open-modal-button
                                    wire:key="edit-establishment-{{ $establishment->id }}"
                                    rounded=true
                                    hasTooltip=true
                                    :tooltip="__('toolTips.establishment.update')"
                                    icon="edit"
                                       :modalTitleOptions="['acronym' => $establishment->acronym]"
                                    :modalContent="[
                                        'name' => 'app.admin.establishment-modal',
                                        'parameters' => ['id' => $establishment->id],
                                    ]"

                                    containsTinyMce=true
                                />


                                <x-core.button icon="view" route="establishment_route" :routeParameters="['id' => $establishment->id]" rounded
                                    hasTooltip :tooltip="__('toolTips.establishment.manage.view')" />

                                {{-- MAP --}}
                                <x-core.button icon="map" function="openGoogleMap" :parameters="[$establishment->longitude, $establishment->latitude]" rounded
                                    hasTooltip :tooltip="__('toolTips.establishment.location.map')" />
                            </td>
                            <td scope="row">{{ $establishment->acronym }}</td>
                            <td>{{ $establishment->name_fr }}</td>
                            <td>{{ $establishment->name_ar }}</td>
                            <td>{{ $establishment->name_en }}</td>
                            <td>{{ $establishment->email }}</td>
                            <td>{{ $establishment->tel }}</td>
                            <td>{{ $establishment->fax }}</td>
                            <td>{{ $establishment->daira_name }}</td>
                            <td>{{ $establishment->created_at->format('d-m-Y') }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $this->establishments->links('components.core.pagination') }}
    @else
        <div class="table__footer">
            <h2>@lang('tables.establishments.not_found')</h2>
        </div>
    @endif
</div>

@script
    <script>
        Livewire.on('open-google-map', url => {
            window.open(url, '_blank'); // opens in new tab
        });
    </script>
@endscript
