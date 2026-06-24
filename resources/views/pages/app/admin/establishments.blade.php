@extends('layouts.core-layout')
@section('pageContent')
    <div class="container__header">

        <div class="container__header__top">
            <livewire:core.breadcrumb :$breadcrumbLinks />
        </div>
        <div class="container__header__bottom">
            <h2>@lang('pages.establishments.titles.main')</h2>
            <livewire:core.open-modal-button
            :text="__('modals.establishment.actions.add')"
            variant="primary"
             icon="add"
             :$modalTitle
             :$modalContent />
        </div>

    </div>


    <livewire:app.admin.establishments-table />
@endsection
