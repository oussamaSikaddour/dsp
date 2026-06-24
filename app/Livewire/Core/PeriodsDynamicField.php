<?php

namespace App\Livewire\Core;

use Livewire\Attributes\Modelable;
use Livewire\Component;

class PeriodsDynamicField extends Component
{
    #[Modelable]
    public $items = [];

    public $label = '';
    public $addTooltip = '';
    public $removeTooltip = '';

    public array $hoursOptions = [];

    public function mount(): void
    {

        $this->addTooltip = __('dynamic_fields.working_period.add');
        $this->removeTooltip = __('dynamic_fields.working_period.remove');

        $this->hoursOptions = config('core.dates.HOURS', []);
    }

    public function addItem()
    {
        if (count($this->items) < 10) {
            $this->items[] = [
                'start' => '',
                'end' => '',
            ];
        }
    }

    public function removeItem($index)
    {
        if (count($this->items) > 1 && isset($this->items[$index])) {
            unset($this->items[$index]);
            $this->items = array_values($this->items);
        }
    }

    public function updated($property, $value): void
    {
        if (preg_match('/items\.(\d+)\.(start|end)/', $property, $matches)) {
            $index = (int) $matches[1];
            $field = $matches[2];

            $start = $this->items[$index]['start'] ?? null;
            $end   = $this->items[$index]['end'] ?? null;

            if ($start && $end) {
                if ($this->toMinutes($start) >= $this->toMinutes($end)) {
                    // revert only the last changed field
                    $this->items[$index][$field] = '';
                    return;
                }
            }
        }
    }

    private function toMinutes(string $time): int
    {
        [$h, $m] = explode(':', $time);
        return ((int) $h * 60) + (int) $m;
    }

    public function render()
    {
        return view('livewire.core.periods-dynamic-field');
    }
}
