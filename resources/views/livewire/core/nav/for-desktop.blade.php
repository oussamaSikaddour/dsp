@if (!$forLandingPage)

    <header class="header">
        <nav class="nav" aria-labelledby="main-nav">
            <h2 id="main-nav" class="sr-only">
                Main navigation
            </h2>

            @auth
                <div class="nav__addons">
                    @canany(['admin-access', 'super-admin-access', 'social-admin-access'])
                        <x-core.side-bar.open-btn html_id="mainMenuDeskTopBtn" />
                    @endcanany
                    <livewire:core.nav-logo />
                </div>

                <ol class="nav__items">
                    <x-core.nav.link route="dashboard" :label="__('pages.dashboard.name')" />
                </ol>

                <ol class="nav__items">
                    <livewire:core.notifications-button wire:key="nb-desktop" />
                    <livewire:core.nav.user-button wire:key="unb-desktop" />
                </ol>
            @endauth

            @guest

                <div class="nav__addons">
                    <livewire:core.nav-logo />
                </div>
                <ol class="nav__items">

                    {{-- <x-core.nav.link route="REGISTER" :label="__('pages.register.name')" /> --}}
                </ol>
            @endguest

            <livewire:core.lang-menu wire:key="lang-menu-desktop" />
              <livewire:core.color-picker wire:key="color-picker-desktop" />
        </nav>
    </header>
@else
    <header class="header">
        <nav class="nav" aria-labelledby="main-nav">
            <h2 id="main-nav" class="sr-only">
                Main navigation
            </h2>

            @auth
                <div class="nav__addons">
                    @canany(['admin-access', 'super-admin-access', 'social-admin-access'])
                        <x-core.side-bar.open-btn html_id="mainMenuDeskTopBtn" />
                    @endcanany
                    <livewire:core.nav-logo />
                </div>

                <ol class="nav__items">



                    <x-core.nav.link route="dashboard" :label="__('pages.dashboard.name')" />
                </ol>



                <ol class="nav__items">
                    <livewire:core.nav.user-button wire:key="unb-desktop" />
                </ol>
            @endauth

            @guest

                <div class="nav__addons">
                    <livewire:core.nav-logo />
                </div>


            @endguest

            <livewire:core.lang-menu wire:key="lang-menu-desktop" />
            <livewire:core.color-picker wire:key="color-picker-desktop" />
        </nav>
    </header>


@endif
