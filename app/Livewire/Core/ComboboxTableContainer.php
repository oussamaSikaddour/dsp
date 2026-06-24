<?php

namespace App\Livewire\Core;

use Livewire\Attributes\On;
use Livewire\Component;

class ComboboxTableContainer extends Component
{
    public string $wireKey = 'combobox-table-body-default';
    public array $component = [];

    #[On('combobox-table:show')]
    public function showComboboxTable($htmlId = null, $component = []): void
    {


        $this->component = (array) $component;

        $componentName = $this->component['name'] ?? 'default';
        $htmlIdPart = $htmlId ?: 'default';

        $this->wireKey = 'combobox-' . md5($componentName . '-' . $htmlIdPart);
    }

    public function render()
    {
        return view('livewire.core.combobox-table-container');
    }
}
