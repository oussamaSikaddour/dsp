<?php

namespace App\Livewire\App\Guest;

use App\Enum\Core\Web\RoutesNames;
use App\Livewire\Forms\App\RegisterForm;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Register extends Component
{
    public RegisterForm $form;

    /*
    |---------------------------------------
    | ROUTES
    |---------------------------------------
    */
    #[Computed]
    public function loginRoute()
    {
        return RoutesNames::LOGIN->value;
    }

    /*
    |---------------------------------------
    | SUBMIT
    |---------------------------------------
    */
    public function handelSubmit()
    {
        $this->dispatch('form-submitted');

        $response = $this->form->save();

        $this->form->reset();

        if ($response['status']) {

            return $this->redirectRoute(
                $response['data']['route']
            );

        } else {

            $this->dispatch('open-errors', $response['errors']);
        }
    }

    public function render()
    {
        return view('livewire.app.guest.register');
    }
}
