@extends('layouts.core-layout')
@section('pageContent')
    <div class="container__header">

        <div class="container__header__top">

            @if (count($breadcrumbLinks) > 0)
                <livewire:core.breadcrumb :$breadcrumbLinks />
            @endif

        </div>

        <div class="container__header__bottom">


            <h2>@lang('pages.service_patients.titles.main',['name'=>$name])</h2>

            {{-- <livewire:core.open-modal-button
            :text="__('modals.patient.actions.add.patient')"
            variant="primary"
             icon="add"
            :$modalTitle
            :$modalContent /> --}}


        </div>
    </div>
    <livewire:app.patients-table :$isForServicePersonnel
    :$serviceId />
@endsection
