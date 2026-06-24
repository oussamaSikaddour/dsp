<?php

namespace App\Livewire\Core;

use Livewire\Attributes\Modelable;
use Livewire\Component;

class DaysOffDynamicField extends Component
{
    #[Modelable]
    public $items = [];

    public $label = '';
    public $addTooltip = '';
    public $removeTooltip = '';



    public function mount(){
                $this->addTooltip = __('dynamic_fields.day_off.add');
    $this->removeTooltip = __('dynamic_fields.day_off.remove');
    }
    public function addItem()
    {
        if (count($this->items) < 50) {
            $this->items[] = '';
        }
    }

    public function removeItem($index)
    {
        if (isset($this->items[$index])) {
            unset($this->items[$index]);
            $this->items = array_values($this->items);
        }
    }

    public function render()
    {
        return view('livewire.core.daysoff-dynamic-field');
    }
}
