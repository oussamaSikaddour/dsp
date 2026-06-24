<div class="table__container" x-on:update-users-table.window="$wire.$refresh()">

    <div class="table__header">
        <h3>@lang('tables.users.info')</h3>

        <div class="table__header__actions">

            @canany([
                // 'super-admin-access', 'admin-access',
            'establishment-admin-access'])
                <span wire:loading wire:target="excelFile">
                    <x-core.loading />
                </span>

                <x-core.file-input
                    icon="upload"
                    :tooltip="__('toolTips.user.manage.users')"
                    model="excelFile"
                    types="excel"
                    type="icon_only"
                />

                <x-core.button
                    icon="export"
                    function="generateEmptyUsersExcel"
                    rounded
                    hasTooltip
                    :tooltip="__('toolTips.user.excel.empty')"
                />

                <x-core.button
                    variant="success"
                    icon="export"
                    function="generateUsersExcel"
                    rounded
                    hasTooltip
                    :tooltip="__('toolTips.user.excel.export')"
                />
            @endcanany

            <x-core.button
                icon="filter"
                rounded
                hasTooltip
                :tooltip="__('toolTips.common.filters')"
                :extraClasses="['table__filters__btn']"
            />

            <x-core.form.selector
                htmlId="TP-upp"
                model="perPage"
                :data="$perPageOptions"
                type="filter"
                :tooltip="__('toolTips.common.per_page')"
            />

        </div>
    </div>

    {{-- FILTERS --}}
    <div class="table__filters" wire:ignore>
        <div class="form__container">
            <form class="form">

                <div class="row">
                    <x-core.form.input
                        model="name"
                        :label="__('tables.users.name')"
                        type="text"
                        html_id="u-NameUT"
                        role="filter"
                    />

                    <x-core.form.input
                        model="email"
                        :label="__('tables.users.email')"
                        type="text"
                        html_id="u-EmailUT"
                        role="filter"
                    />
                </div>

                <div class="form__actions">
                    <x-core.button
                        hasTooltip
                        :tooltip="__('toolTips.common.resetFilters')"
                        type="submit"
                        variant="primary"
                        function="resetFilters"
                        prevent
                        rounded
                        icon="refresh"
                    />
                </div>

            </form>
        </div>
    </div>

    {{-- TABLE --}}
    @if ($this->users->isNotEmpty())

        <div class="table__body">
            <table class="table">

                <thead>
                    <tr>
                        <th>@lang('tables.common.actions')</th>

                        <x-core.table.sortable-th
                            model="last_name"
                            :label="__('tables.users.last_name')"
                            :$sortDirection
                            :$sortBy
                        />

                        <x-core.table.sortable-th
                            model="first_name"
                            :label="__('tables.users.first_name')"
                            :$sortDirection
                            :$sortBy
                        />

                        <x-core.table.sortable-th
                            model="name"
                            :label="__('tables.users.name')"
                            :$sortDirection
                            :$sortBy
                        />

                        <x-core.table.sortable-th
                            model="email"
                            :label="__('tables.users.email')"
                            :$sortDirection
                            :$sortBy
                        />

                        <x-core.table.sortable-th
                            model="created_at"
                            :label="__('tables.users.registration_date')"
                            :$sortDirection
                            :$sortBy
                        />
                    </tr>
                </thead>

                <tbody>
                    @php
                        $superAdminCount = \App\Models\User::superAdmins()->count();
                    @endphp

                    @foreach ($this->users as $user)

                        <tr wire:key="user-{{ $user->id }}">

                            <td>

                                {{-- DELETE (SAFE) --}}
                                @if (!($user->is_super_admin && $superAdminCount <= 1))
                                    <x-core.button
                                        variant="danger"
                                        icon="delete"
                                        function="openDeleteUserDialog"
                                        :parameters="[$user->id]"
                                        rounded
                                        hasTooltip
                                        :tooltip="__('toolTips.user.delete')"
                                    />
                                @endif

                                {{-- EDIT --}}
                                <livewire:core.open-modal-button
                                    wire:key="edit-user-{{ $user->id }}"
                                    rounded
                                    hasTooltip
                                    :tooltip="__('toolTips.user.update')"
                                    icon="edit"
                                    modalTitle="modals.user.actions.update"
                                    :modalTitleOptions="['name' => $user->name]"
                                    :modalContent="[
                                        'name' => 'core.user-modal',
                                        'parameters' => ['id' => $user->id],
                                    ]"
                                />

                                {{-- ROLES --}}
                                @canany(['super-admin-access', 'admin-access'])
                                    <livewire:core.open-modal-button
                                        wire:key="roles-user-{{ $user->id }}"
                                        rounded
                                        hasTooltip
                                        :tooltip="__('toolTips.user.manage.roles')"
                                        icon="permissions"
                                        modalTitle="modals.user.actions.manage.roles"
                                        :modalTitleOptions="['name' => $user->name]"
                                        :modalContent="[
                                            'name' => 'core.super-admin.roles-modal',
                                            'parameters' => ['id' => $user->id],
                                        ]"
                                    />
                                @endcanany

                            </td>

                            <td>{{ $user->last_name }}</td>
                            <td>{{ $user->first_name }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at->format('Y-m-d') }}</td>

                        </tr>

                    @endforeach
                </tbody>

            </table>
        </div>

        {{ $this->users->links('components.core.pagination') }}

    @else
        <div class="table__footer">
            <h2>@lang('tables.users.not_found')</h2>
        </div>
    @endif

</div>
