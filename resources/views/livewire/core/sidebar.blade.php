<aside class="sidebar">
    <ul id="mainMenu" role="menu" aria-labelledby="menubutton" class="sidebar__items">


        @can('super-admin-access')
            <x-core.side-bar.dropdown :items="$superAdminDropdownItems" :dropdownLink="$superAdminDropdownLink" />
        @endcan
        {{-- @canany(['admin-access'])
            <x-core.side-bar.dropdown :items="$adminDropdownItems" :dropdownLink="$adminDropdownLink" />
        @endcanany --}}
    </ul>
</aside>
