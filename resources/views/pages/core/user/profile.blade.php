@extends('layouts.core-layout')
@section('pageContent')
    <div class="container__header">

        <div class="container__header__top">

            @if (count($breadcrumbLinks) > 0)
                <livewire:core.breadcrumb :$breadcrumbLinks />
            @endif

        </div>

        <div class="container__header__bottom">


            <h2>@lang('pages.profile.titles.main', [
                'name' => $userName,
            ])</h2>




        </div>
    </div>

    <div class="row center self-h-center self-v-center" >
        <livewire:core.user-modal :id="$userId" />

    </div>
@endsection
