@extends('layouts.core-layout')
@section('pageContent')
    <div class="container__header">

        <div class="container__header__top">

            @if (count($breadcrumbLinks) > 0)
                <livewire:core.breadcrumb :$breadcrumbLinks />
            @endif

        </div>

        <div class="container__header__bottom">


            <h2>@lang('pages.establishment.titles.main', $modalTitleOptions)</h2>

            <livewire:core.open-modal-button :text="__('modals.user.actions.add', $modalTitleOptions)" variant="primary" icon="add" :$modalTitle
                :$modalTitleOptions :$modalContent />


        </div>
    </div>


    <div class="column center">
        <livewire:app.admin.establishment-types-manager :$establishmentId />

        <livewire:core.users-table :$managerableId :$managerableType :$establishmentName  :$establishmentId/>

    </div>
@endsection
