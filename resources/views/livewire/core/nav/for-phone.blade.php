@if (!$forLandingPage)
    <nav class="nav--phone" aria-labelledby="main-nav-phone">
        <h2 id="main-nav-phone" class="sr-only">
            Main navigation
        </h2>
        <ul class="nav__items">
            @auth

                <x-core.nav.link route="index" :label="__('pages.landing_page.name')" />
                <x-core.nav.link route="dashboard" :label="__('pages.dashboard.name')" />




                <livewire:core.notifications-button wire:key="nb-phone" />
                <livewire:core.nav.user-button wire:key="unb-phone" />

            @endauth
            @guest



                <x-core.nav.link route="index" :label="__('pages.landing_page.name')" />



                {{-- <x-core.nav.link route="register" :label="__('pages.register.name')" /> --}}
            @endguest

                    <livewire:core.lang-menu wire:key="lmp" />
            <livewire:core.color-picker wire:key="color-picker-phone" />
        </ul>

    </nav>
@else
    <nav class="nav--phone" aria-labelledby="main-nav-phone">
        <h2 id="main-nav-phone" class="sr-only">
            Main navigation
        </h2>
        <ul class="nav__items">
            @auth

                <x-core.nav.link route="#hero" :label="__('pages.landing_page.links.hero')" />
                <x-core.nav.link route="#aboutUs" :label="__('pages.landing_page.links.about_us')" />
                <x-core.nav.link route="#myWorks" :label="__('pages.landing_page.links.my_works')" />
                <x-core.nav.link route="#contactUs" :label="__('pages.landing_page.links.contact_us')" />
                <x-core.nav.link route="dashboard" :label="__('pages.dashboard.name')" />

                <livewire:core.nav.user-button wire:key="unb-phone" />

            @endauth
            @guest


                {{-- <x-core.nav.link route="register" :label="__('pages.register.name')" /> --}}
            @endguest

        <livewire:core.lang-menu wire:key="lmp" />
          <livewire:core.color-picker wire:key="color-picker-phone" />
        </ul>

    </nav>


@endif
