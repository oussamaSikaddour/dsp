<form class="form" wire:submit="handelSubmit">

    <p style="text-align: center">
        @lang('forms.register.instructions.email_optional')
    </p>

    <div class="column center">

        {{-- LAST NAME --}}
        <x-core.form.input model="form.last_name" :label="__('forms.user.last_name')" type="text" html_id="registerLastName" />


        {{-- FIRST NAME --}}
        <x-core.form.input model="form.first_name" :label="__('forms.user.first_name')" type="text" html_id="registerFirstName" />


        {{-- NAME (UNIQUE) --}}
        <x-core.form.input model="form.name" :label="__('forms.user.name')" type="text" html_id="registerName" />

        {{-- EMAIL --}}
        <x-core.form.input model="form.email" :label="__('forms.register.email')" type="email" html_id="registerEmail" />

        {{-- PASSWORD --}}
        <x-core.form.password-input model="form.password" :label="__('forms.register.password')" html_id="registerPassword" />

        {{-- TERMS --}}
        <div class="checkbox__group">
            <x-core.form.check-box model="form.agree_terms" :label="__('forms.register.agree_terms')" htmlId="registerAgreeTerms"
                :live="true" />
        </div>

    </div>

    <div class="form__actions">

        <div class="column center">

            <x-core.button href="{{ route($this->loginRoute) }}" :text="__('pages.register.links.login')" />

            <x-core.button type="submit" variant="primary" :text="__('forms.register.actions.submit')" icon="user_add" expectLoading="true"
                fullWidth="true" :wireTargets="['handleSubmit']" prevent="true" />

        </div>

    </div>

</form>
