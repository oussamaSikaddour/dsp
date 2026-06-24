<?php

namespace App\Livewire\Core\Nav;

use App\Models\Menu;
use App\Models\Service;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ForPhone extends Component
{

  public bool $forLandingPage=false;









    public function render()
    {
        return view('livewire.core.nav.for-phone');
    }
}
