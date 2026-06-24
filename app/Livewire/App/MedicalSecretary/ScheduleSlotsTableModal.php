<?php

namespace App\Livewire\App\MedicalSecretary;

use Livewire\Component;

class ScheduleSlotsTableModal extends Component
{

    public int $scheduleDayId;


    public function mount(){
          $this->dispatch('init-table');
        $this->dispatch('init-tooltip');
    }

    public function render()
    {


        return view('livewire.app.medical-secretary.schedule-slots-table-modal');
    }
}
