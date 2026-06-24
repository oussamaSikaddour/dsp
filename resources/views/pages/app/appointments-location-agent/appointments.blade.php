@extends('layouts.core-layout')
@section('pageContent')
    <div class="container__header">

        <div class="container__header__top">

            @if (count($breadcrumbLinks) > 0)
                <livewire:core.breadcrumb :$breadcrumbLinks />
            @endif

        </div>

        <div class="container__header__bottom">


            <h2>@lang('pages.appointments.titles.main', ['name'=>$name])</h2>




        </div>
    </div>

    <livewire:app.appointments-table  :$isForServicePersonnel :$appointmentsLocationId />
@endsection
