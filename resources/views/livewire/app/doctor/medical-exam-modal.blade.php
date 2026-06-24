<div class="modal__body__content">
    <div class="form__container">
        <form class="form">
            <div class="column">
                <p>@lang('forms.medical_exam.report_fr') :</p>
                <livewire:core.tiny-mce-text-area
                    htmlId="MEContentFr"
                    contentUpdatedEvent="set-report-fr"
                    wire:key="MeContentFr"
                    :content="$reportFr" />

                <p>@lang('forms.medical_exam.report_ar') :</p>
                <livewire:core.tiny-mce-text-area
                    htmlId="MEContentAr"
                    contentUpdatedEvent="set-report-ar"
                    wire:key="MeContentAr"
                    :content="$reportAr" />

                <p>@lang('forms.medical_exam.report_en') :</p>
                <livewire:core.tiny-mce-text-area
                    htmlId="MEContentEn"
                    contentUpdatedEvent="set-report-en"
                    wire:key="MeContentEn"
                    :content="$reportEn" />
            </div>



            <div class="form__actions">
                <x-core.button
                    function="handleSubmit"
                    :wireTargets="['handleSubmit']"
                    prevent="true"
                    variant="primary"
                    :text="__('forms.common.actions.submit')"
                    icon="confirm"
                    expectLoading=true
                    fullWidth=true />
            </div>
        </form>
    </div>
</div>
