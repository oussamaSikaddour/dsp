@extends('layouts.core-layout')
@section('pageContent')
    <div class="container__header">

        <div class="container__header__top">

            @if (count($breadcrumbLinks) > 0)
                <livewire:core.breadcrumb :$breadcrumbLinks />
            @endif

        </div>

        <div class="container__header__bottom">


            <h2>@lang('pages.patient.titles.main', $modalTitleOptions)</h2>

            <livewire:core.open-modal-button :text="__('modals.appointment.actions.book', $modalTitleOptions)" variant="primary" icon="book" :$modalTitle
                :$modalTitleOptions :$modalContent />


        </div>
    </div>

    <livewire:app.appointments-table  :$isForAppointmentsLocationAgent :$patientId :patient="$name" />
@endsection
