@extends('layouts.core-layout')

@section('pageContent')
    <div class="container__header">

        <div class="container__header__top">
            <h2>
                @lang('pages.dashboard.titles.main', ['name' => $user->full_name])
            </h2>
        </div>

        <div class="container__header__bottom">

            <h4 style="text-align: center; max-width: 110ch;">
                @lang($notASimpleUser ? 'pages.dashboard.messages.multi_role_user' : 'pages.dashboard.messages.simple_user', $modalTitleOptions)
            </h4>

            <livewire:core.open-modal-button :text="__('modals.patient.actions.add.relative')" variant="primary" icon="add" :modal-title="$modalTitle"
                :modal-title-options="$modalTitleOptions" :modal-content="$modalContent" />

        </div>
    </div>


    <livewire:app.patients-table :openedBy="$user->id" />


    @if ($notASimpleUser)
        <section class="dashboard">

            {{-- SUPER ADMIN + ADMIN --}}
            @canany(['admin-access', 'super-admin-access'])
                <x-core.dashboard-link route="users_route" img="users" :label="__('pages.manage_users.name')" />

                <x-core.dashboard-link route="establishments_route" img="establishments" :label="__('pages.establishments.name')" />
            @endcanany


            {{-- ESTABLISHMENT ADMIN --}}
            @can('establishment-admin-access')
                <x-core.dashboard-link route="establishment_users_route" img="personnel" :label="__('pages.manage_establishment_users.name')" />

                <x-core.dashboard-link route="establishment_services_route" img="services" :label="__('pages.manage_establishment_services.name')" />
            @endcan


            {{-- SERVICE COORDINATOR --}}
            @can('service-coordinator-access')
                <x-core.dashboard-link route="manage_service_route" img="service" :label="__('pages.manage_service.name')" />
            @endcan


            {{-- MEDICAL SECRETARY --}}
            @can('medical-secretary-access')
                <x-core.dashboard-link route="manage_schedules_route" img="schedules" :label="__('pages.manage_schedules.name')" />
            @endcan
            {{-- MEDICAL SECRETARY --}}
            @can('appointments-locations-agent-access')
                <x-core.dashboard-link route="appointments_route" img="appointments" :label="__('pages.appointments.name')" />
                <x-core.dashboard-link route="manage_patients_route" img="patients" :label="__('pages.manage_patients.name')" />
            @endcan
            @can('doctor-access')
                <x-core.dashboard-link route="doctor_appointments_route" img="appointments" :label="__('pages.doctor_appointments.name')" />

            @endcan

             @canany(['doctor-access', 'coordinator-access','medical-secretary-access'])
                <x-core.dashboard-link route="service_patients_route" img="patients" :label="__('pages.service_patients.name')" />
            @endcanany

        </section>
    @endif
@endsection
