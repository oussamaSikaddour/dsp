@extends('layouts.core-layout')

@section('pageContent')
<div class="container__header">

    <div class="container__header__top">

        @if (count($breadcrumbLinks) > 0)
            <livewire:core.breadcrumb :$breadcrumbLinks />
        @endif

    </div>

    <div class="container__header__bottom">

        <h2>
            @lang('pages.manage_service.titles.main', $doctorsModalTitleOptions)
        </h2>

        {{-- ================= DOCTORS MODAL ================= --}}
        <livewire:core.open-modal-button
            :text="__('modals.doctors.actions.manage')"
            variant="primary"
            icon="settings"
            :modalTitle="$doctorsModalTitle"
            :modalTitleOptions="$doctorsModalTitleOptions"
            :modalContent="$doctorsModalContent"
        />

        {{-- ================= MEDICAL SECRETARIES MODAL ================= --}}
        <livewire:core.open-modal-button
            :text="__('modals.medical_secretaries.actions.manage')"
            variant="info"
            icon="settings"
            :modalTitle="$medicalSecretariesModalTitle"
            :modalTitleOptions="$medicalSecretariesModalTitleOptions"
            :modalContent="$medicalSecretariesModalContent"
        />

        {{-- ================= APPOINTMENTS LOCATION AGENTS MODAL ================= --}}
        <livewire:core.open-modal-button
            :text="__('modals.appointments_locations_agents.actions.manage')"
            variant="warning"
            icon="settings"
            :modalTitle="$appointmentsLocationAgentsModalTitle"
            :modalTitleOptions="$appointmentsLocationAgentsModalTitleOptions"
            :modalContent="$appointmentsLocationAgentsModalContent"
        />

    </div>

</div>
@endsection
