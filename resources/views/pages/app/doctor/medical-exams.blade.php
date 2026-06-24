@extends('layouts.core-layout')
@section('pageContent')
    <div class="container__header">

        <div class="container__header__top">

            @if (count($breadcrumbLinks) > 0)
                <livewire:core.breadcrumb :$breadcrumbLinks />
            @endif

        </div>

        <div class="container__header__bottom">


            <h2>@lang('pages.medical_exams.titles.main', $modalTitleOptions)</h2>

            <livewire:core.open-modal-button :text="__('modals.medical_exam.actions.add.simple')" variant="primary" icon="book" :$modalTitle :$containsTinyMce
                :$modalTitleOptions :$modalContent />


        </div>
    </div>

    <livewire:app.doctor.medical-exams-table  :$specialtyId :$patientId/>
@endsection
