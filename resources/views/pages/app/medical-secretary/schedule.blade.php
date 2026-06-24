@extends('layouts.core-layout')
@section('pageContent')
    <div class="container__header">

        <div class="container__header__top">

            @if (count($breadcrumbLinks) > 0)
                <livewire:core.breadcrumb :$breadcrumbLinks />
            @endif

            <livewire:app.medical-secretary.generate-schedule-days-button :$schedule />
        </div>

        <div class="container__header__bottom">


            <h2>@lang('pages.manage_schedule.titles.main', [
                'service' => $schedule->service->localized_name,
                'name' => $schedule->localized_name,
            ])</h2>

        </div>
    </div>

    <livewire:app.medical-secretary.schedule-days-table
    :$schedule
    :$scheduleId
/>
@endsection
