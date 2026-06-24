    <div class="modal__body__content">

        <div class="form__container">
            <form class="form" wire:submit="handleSubmit">
                <!-- names Section -->
                <div class="row center">
                    <x-core.form.input model="{{ $form }}.acronym" :label="__('forms.establishment.acronym')" type="text"
                        html_id="Mestablishment-acro" />
                    <x-core.form.input model="{{ $form }}.email" :label="__('forms.establishment.email')" type="email"
                        html_id="Mestablishment-Email" />

                </div>
                <div class="row center">
                    <x-core.form.input model="{{ $form }}.name_fr" :label="__('forms.establishment.name_fr')" type="text"
                        html_id="Mestablishment-aFr" />
                    <x-core.form.input model="{{ $form }}.name_ar" :label="__('forms.establishment.name_ar')" type="text"
                        html_id="Mestablishment-aFr" />
                    <x-core.form.input model="{{ $form }}.name_en" :label="__('forms.establishment.name_en')" type="text"
                        html_id="Mestablishment-aEn" />
                </div>
                <div class="row center">
                    <x-core.form.input model="{{ $form }}.address_fr" :label="__('forms.establishment.address_fr')" type="text"
                        html_id="Mestablishment-addFr" />
                    <x-core.form.input model="{{ $form }}.address_ar" :label="__('forms.establishment.address_ar')" type="text"
                        html_id="Mestablishment-addFr" />
                    <x-core.form.input model="{{ $form }}.address_en" :label="__('forms.establishment.address_en')" type="text"
                        html_id="Mestablishment-addEn" />
                </div>
                <div class="row center">
                    <x-core.form.input model="{{ $form }}.tel" :label="__('forms.establishment.tel')" type="text"
                        html_id="Mestablishment-tel" />
                    <x-core.form.input model="{{ $form }}.fax" :label="__('forms.establishment.fax')" type="text"
                        html_id="Mestablishment-fax" />

                </div>
                <div class="row center">


                    <x-core.form.selector htmlId="Mestablishment-Daira" model="{{ $form }}.daira_id"
                        :label="__('forms.establishment.daira')" :data="$dairatesOptions" :showError="true" />

                    <x-core.form.input model="{{ $form }}.longitude" :label="__('forms.establishment.longitude')" type="text"
                        html_id="Mestablishment-longitude" />
                    <x-core.form.input model="{{ $form }}.latitude" :label="__('forms.establishment.latitude')" type="text"
                        html_id="Mestablishment-latitude" />

                </div>



                <!-- Content Editors Section -->
                <div class="column">
                    <!-- French Content -->
                    <p>@lang('forms.establishment.description_fr') :</p>
                    <livewire:core.tiny-mce-text-area htmlId="Maestablishmentfr"
                        contentUpdatedEvent="set-description-fr" wire:key="MaestablishmentFr" :content="$descriptionFr" />



                    <!-- Arabic Content -->
                    <p>@lang('forms.establishment.description_ar') :</p>
                    <livewire:core.tiny-mce-text-area htmlId="MaestablishmentAr"
                        contentUpdatedEvent="set-description-ar" wire:key="MaestablishmentAr" :content="$descriptionAr" />

                    <!-- English Content -->
                    <p>@lang('forms.establishment.description_en') :</p>
                    <livewire:core.tiny-mce-text-area htmlId="MaestablishmentEn"
                        contentUpdatedEvent="set-description-en" wire:key="MaestablishmentEn" :content="$descriptionEn" />
                </div>





                <!-- Form Actions -->
                <div class="form__actions">


                    <x-core.button type="submit" variant="primary" :text="__('forms.common.actions.submit')" icon="confirm" expectLoading=true
                        fullWidth=true :wireTargets="['handleSubmit']" />

            </form>
            </form>
        </div>
    </div>
