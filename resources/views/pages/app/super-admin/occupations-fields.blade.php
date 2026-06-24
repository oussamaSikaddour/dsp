@extends('layouts.core-layout')
@section('pageContent')
    <div class="container__header">

        <div class="container__header__top">

            <livewire:core.open-modal-button :text="__('modals.field.actions.add')" variant="primary" icon="add" :$modalTitle :$modalContent />
            <h2>@lang('pages.occupation_fields.titles.main')</h2>

        </div>

    </div>
    <livewire:app.super-admin.fields-table />
@endsection
