@extends('layouts.core-layout')
@section('pageContent')
    <div class="container__header">

        <div class="container__header__top">

            @if (count($breadcrumbLinks) > 0)
                <livewire:core.breadcrumb :$breadcrumbLinks />
            @endif

        </div>

        <div class="container__header__bottom">


            <h2>@lang('pages.manage_establishment_users.titles.main', $modalTitleOptions)</h2>

            <livewire:core.open-modal-button :text="__('modals.user.actions.add', $modalTitleOptions)" variant="primary" icon="add" :$modalTitle
                :$modalTitleOptions :$modalContent />


        </div>
    </div>

            <livewire:core.users-table :$establishmentId  />
@endsection
