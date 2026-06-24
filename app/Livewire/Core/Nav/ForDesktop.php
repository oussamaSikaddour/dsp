<?php

namespace App\Livewire\Core\Nav;

use App\Enum\Core\Web\RoutesNames;
use App\Models\Menu;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class ForDesktop extends Component
{

    public bool $forLandingPage = false;


    // fired from toast success after admin changed their own roles
    #[On('logout-yourself')]
    public function logout(): void
    {
        $this->dispatch('redirect', url: route(RoutesNames::LOG_OUT->value));
    }






    public function render()
    {
        return view('livewire.core.nav.for-desktop');
    }
}
