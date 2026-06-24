<?php

namespace App\Livewire\App;

use App\Models\Establishment;
use App\Traits\Core\Common\GeneralTrait;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class AppointmentsLocationsDynamicField extends Component
{
    use GeneralTrait;

    #[Modelable]
    public $items = [];

    public $label = '';
    public $addTooltip = '';
    public $removeTooltip = '';

    public string $local = 'fr';

    public array $locationsOptions = [];

    public function mount(): void
    {

        $this->addTooltip = __('dynamic_fields.appointments_location.add');
    $this->removeTooltip = __('dynamic_fields.appointments_location.remove');
        $this->local = app()->getLocale();

        $this->locationsOptions = $this->populateSelectorOption(
            $this->appointmentsLocations(),
            'id',
            'name',
            __('selectors.default.appointments_locations')
        );
    }

    /**
     * Get establishments that support appointment locations
     */
    public function appointmentsLocations()
    {
        return Establishment::query()
            ->whereJsonContains('types', 'appointment_locations')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->{"name_{$this->local}"} ?? $item->name_fr,
                ];
            });
    }

    public function addItem()
    {
        if (count($this->items) < 10) {
            $this->items[] = [
                'location_id' => '',
                'capacity' => 1,
            ];
        }
    }

    public function removeItem($index)
    {
        if (isset($this->items[$index])) {
            unset($this->items[$index]);
            $this->items = array_values($this->items);
        }
    }

    public function updated($property, $value): void
    {
        /**
         * Ensure capacity is always >= 1
         */
        if (preg_match('/items\.(\d+)\.capacity/', $property, $matches)) {
            $index = (int) $matches[1];

            if (($this->items[$index]['capacity'] ?? 0) < 1) {
                $this->items[$index]['capacity'] = 1;
            }
        }

        /**
         * Prevent duplicate location_id selection
         */
        if (str_contains($property, 'location_id')) {

            $selectedLocations = [];

            foreach ($this->items as $index => $item) {

                if (empty($item['location_id'])) {
                    continue;
                }

                if (in_array($item['location_id'], $selectedLocations)) {

                    // dispatch your error
                    $this->dispatch(
                        'open-errors',
                        __("forms.schedule.errors.multiple_location_selection")
                    );

                    // reset duplicated value
                    $this->items[$index]['location_id'] = '';

                    return;
                }

                $selectedLocations[] = $item['location_id'];
            }
        }
    }

    public function render()
    {
        return view('livewire.app.appointments-locations-dynamic-field');
    }
}
