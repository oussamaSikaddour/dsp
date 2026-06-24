@php
    $formModel = fn(string $field) => "{$form}.{$field}";
@endphp

<div class="modal__body__content">

    <div class="form__container">

        <form class="form" wire:submit="handleSubmit">

            <!-- ===================== -->
            <!-- BASIC INFO -->
            <!-- ===================== -->

            <div class="row center">

                @if ($patientId)
                    <x-core.form.input :model="$formModel('code')" :label="__('forms.patient.code')" type="text" html_id="patient-code"
                        :disabled="true" />
                @endif

                <x-core.form.input :model="$formModel('last_name_fr')" :label="__('forms.patient.last_name_fr')" type="text" html_id="patient-last-name-fr" />
                <x-core.form.input :model="$formModel('first_name_fr')" :label="__('forms.patient.first_name_fr')" type="text" html_id="patient-first-name-fr" />

            </div>

            <div class="row">



                <x-core.form.input :model="$formModel('last_name_ar')" :label="__('forms.patient.last_name_ar')" type="text" html_id="patient-last-name-ar" />

                <x-core.form.input :model="$formModel('first_name_ar')" :label="__('forms.patient.first_name_ar')" type="text"
                    html_id="patient-first-name-ar" />




            </div>

            <!-- ===================== -->
            <!-- GENDER -->
            <!-- ===================== -->

            <div class="row center">

                <x-core.form.selector :model="$formModel('gender')" :label="__('forms.patient.gender')" :data="$gendersOptions"
                    htmlId="patient-gender" />

                <x-core.form.input :model="$formModel('birth_date')" :label="__('forms.patient.birth_date')" type="date" html_id="patient-birth-date" />
            </div>

            <!-- ===================== -->
            <!-- DAIRA + COMMUNE -->
            <!-- ===================== -->

            <div class="row center">

                <x-core.form.selector model="dairaId" :label="__('forms.patient.daira')" :data="$dairatesOptions" htmlId="patient-daira"
                    type="filter" />


                <x-core.form.selector :model="$formModel('commune_id')" :label="__('forms.patient.commune_id')" :data="$communesOptions"
                    htmlId="patient-commune" />

            </div>

            <!-- ===================== -->
            <!-- BIRTH PLACE -->
            <!-- ===================== -->

            <div class="row center">

                <x-core.form.input :model="$formModel('birth_place_fr')" :label="__('forms.patient.birth_place_fr')" type="text"
                    html_id="patient-birth-place-fr" />

                <x-core.form.input :model="$formModel('birth_place_ar')" :label="__('forms.patient.birth_place_ar')" type="text"
                    html_id="patient-birth-place-ar" />

                <x-core.form.input :model="$formModel('birth_place_en')" :label="__('forms.patient.birth_place_en')" type="text"
                    html_id="patient-birth-place-en" />

            </div>

            <!-- ===================== -->
            <!-- ADDRESS -->
            <!-- ===================== -->

            <div class="row">

                <x-core.form.input :model="$formModel('address_fr')" :label="__('forms.patient.address_fr')" type="text" html_id="patient-address-fr" />

                <x-core.form.input :model="$formModel('address_ar')" :label="__('forms.patient.address_ar')" type="text" html_id="patient-address-ar" />

                <x-core.form.input :model="$formModel('address_en')" :label="__('forms.patient.address_en')" type="text" html_id="patient-address-en" />

            </div>

            <!-- ===================== -->
            <!-- FAMILY -->
            <!-- ===================== -->

            <div class="row center">

                <x-core.form.selector :model="$formModel('father_id')" :label="__('forms.patient.father_id')" :data="$fatherOptions"
                    htmlId="patient-father" />

                <x-core.form.selector :model="$formModel('mother_id')" :label="__('forms.patient.mother_id')" :data="$motherOptions"
                    htmlId="patient-mother" />

            </div>

            <!-- ===================== -->
            <!-- CONTACT -->
            <!-- ===================== -->

            <div class="row center">

                <x-core.form.input :model="$formModel('tel')" :label="__('forms.patient.tel')" type="text" html_id="patient-tel" />

                <x-core.form.input :model="$formModel('insurance_number')" :label="__('forms.patient.insurance_number')" type="text" html_id="patient-insurance" />

            </div>

            <!-- ===================== -->
            <!-- ACTIONS -->
            <!-- ===================== -->

            <div class="form__actions">

                <x-core.button type="submit" variant="primary" :text="__('forms.common.actions.submit')" icon="confirm" expectLoading="true"
                    fullWidth="true" :wireTargets="['handleSubmit']" />

            </div>

        </form>

    </div>

</div>
