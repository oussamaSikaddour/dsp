<form class="form" wire:submit="handelSubmit">
    <h3 class="heading__title">@lang('pages.login.titles.main')</h3>

    <div class="column center">
        <x-core.form.input
            model="form.login"
            :label="__('forms.login.login')"
            type="text"
            html_id="loginField"
        />

        <x-core.form.password-input
            model="form.password"
            :label="__('forms.login.password')"
            html_id="loginPassword"
        />
    </div>

    <div class="form__actions">
        <div class="column center">
            <x-core.button
                href="{{ route($this->forgetPasswordRoute) }}"
                :text="__('pages.login.links.forgot_password')"
            />

            <x-core.button
                type="submit"
                variant="success"
                :text="__('forms.login.actions.submit')"
                icon="login"
                expectLoading=true
                fullWidth=true
            />

                 <x-core.button href="{{ route($this->registerPageRoute) }}" :text="__('pages.login.links.register')" />
        </div>
    </div>
</form>
