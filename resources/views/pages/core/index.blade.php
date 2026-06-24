@extends('layouts.app-layout')

@section('pageContent')
    <livewire:app.landing-page.sections.hero-carousel :$hero />

    <section class="welcome self-h-center self-v-center">
        <div class="welcome__header">
            <div class="welcome__logo">
                <img src="{{ asset('assets/core/icons/sante.png') }}" alt="Santé" />
            </div>

            <div class="column center">
                <h1 class="welcome__title">
                    {{ __('pages.landing_page.welcome.country_name') }}
                </h1>

                <h1 class="welcome__title">
                    {{ __('pages.landing_page.welcome.ministry_name') }}
                </h1>
            </div>

            <div class="welcome__logo">
                <img src="{{ asset('assets/core/icons/flag.png') }}" alt="Algeria" />
            </div>
        </div>

        <div class="welcome__body">
            <div class="column center">
                <h2>
                    {{ __('pages.landing_page.welcome.title') }}
                </h2>

                <p class="welcome__description">
                    {{ __('pages.landing_page.welcome.description') }}
                </p>
            </div>
        </div>

        <div class="welcome__footer">

            <div class="welcome__card">
                <span class="welcome__label">
                    {{ __('pages.landing_page.welcome.register_text') }}
                </span>

                <x-core.button
                    :text="__('pages.landing_page.welcome.register_button')"
                    variant="primary"
                    route="register"
                    full-width
                />
            </div>
                        <div class="welcome__card">
                <span class="welcome__label">
                    {{ __('pages.landing_page.welcome.login_text') }}
                </span>

                <x-core.button
                    :text="__('pages.landing_page.welcome.login_button')"
                    variant="success"
                    route="login"
                    full-width
                />
            </div>

        </div>
    </section>
@endsection
