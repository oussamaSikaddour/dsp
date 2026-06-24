<div class="modal__body__content">
    <div class="form__container">

        <form class="form" wire:submit.prevent="handleSubmit">

            <!-- ===================== -->
            <!-- VIEW ONLY MODE -->
            <!-- ===================== -->
            @if($isForAppointmentsLocationAgent)

                @if($existingImageUrl)
                    <div class="preview mt-3">
                        <img src="{{ $existingImageUrl }}" alt="Referral Letter">
                    </div>
                @else
                    <p class="text-muted">No referral letter uploaded.</p>
                @endif

            @else

                <!-- ===================== -->
                <!-- EDIT MODE -->
                <!-- ===================== -->

                <div class="column center"
                     x-data="{ uploading: false, progress: 0 }"
                     x-on:livewire-upload-start="uploading = true"
                     x-on:livewire-upload-finish="uploading = false"
                     x-on:livewire-upload-cancel="uploading = false"
                     x-on:livewire-upload-error="uploading = false"
                     x-on:livewire-upload-progress="progress = $event.detail.progress">

                    <x-core.file-input
                        model="updateForm.referral_letter"
                        types="img"
                        type="file"
                        :text="__('forms.appointment.referral_letter_short')"
                    />

                    <div x-show="uploading" class="w-full mt-2">
                        <progress max="100" x-bind:value="progress"></progress>
                    </div>
                </div>

                <!-- preview (only in edit mode) -->
                @if($existingImageUrl)
                    <div class="preview mt-3">
                        <img src="{{ $existingImageUrl }}" alt="Referral Letter">
                    </div>
                @endif

            @endif

            <!-- ===================== -->
            <!-- ACTIONS -->
            <!-- ===================== -->

            @if(!$isForAppointmentsLocationAgent)
                <div class="form__actions">
                    <x-core.button
                        function="handleSubmit"
                        :wireTargets="['handleSubmit']"
                        prevent="true"
                        variant="primary"
                        :text="__('forms.common.actions.submit')"
                        icon="confirm"
                        expectLoading="true"
                        fullWidth="true"
                    />
                </div>
            @endif

        </form>

    </div>
</div>
