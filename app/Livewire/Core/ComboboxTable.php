<?php

namespace App\Livewire\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class ComboboxTable extends Component
{
    public string $htmlId = '';
    public ?string $label = null;
    public string $type = 'text';
    public string $role = '';
    public mixed $min = null;
    public mixed $max = null;
    public ?string $placeHolder = null;
    public string $icon = '';
    public string $iconHtml = '';
    public ?string $variant = null;
    public array|string $extraClasses = [];
    public string $tooltip = '';
    public bool $hasTooltip = false;
    public ?string $model = null;

    public string $selectionEvent = 'combobox-table-value-selected';

    #[Modelable]
    public $value = null;

    public ?string $displayValue = null;
    public ?string $initialDisplayValue = null;

    /**
     * Can accept:
     * - full class name: App\Models\Article::class
     * - short alias: "article"
     */
    public ?string $displayModelClass = null;

    /**
     * Example: "name"
     */
    public ?string $displayAttribute = null;

    public array $comboboxTableContent = [];

    public function mount(): void
    {
        $this->htmlId = $this->htmlId ?: 'combobox-' . Str::random(8);
        $this->iconHtml = $this->resolveIconHtml($this->icon);

        if ($this->displayValue === null) {
            if ($this->initialDisplayValue !== null) {
                $this->displayValue = $this->initialDisplayValue;
            } else {
                $this->displayValue = $this->resolveDisplayValueFromModel();
            }
        }
    }

    protected function getListeners(): array
    {
        return [
            $this->selectionEvent => 'setSelectedValue',
        ];
    }

    private function resolveIconHtml(string $icon): string
    {
        if (!$icon) {
            return '';
        }

        $configIcon = config("core.icons.FONTAWESOME.$icon");

        if (!$configIcon) {
            Log::warning("Icon '{$icon}' not found in config(core.icons.FONTAWESOME.*)");
            return '<i class="fa-solid fa-question"></i>';
        }

        return $configIcon;
    }

    private function resolveModelClass(): ?string
    {
        if (!$this->displayModelClass) {
            return null;
        }

        // If full class name is passed
        if (class_exists($this->displayModelClass)) {
            return $this->displayModelClass;
        }

        // Auto resolve: "article" => App\Models\Article
        $autoResolved = 'App\\Models\\' . Str::studly($this->displayModelClass);

        if (class_exists($autoResolved)) {
            return $autoResolved;
        }

        return null;
    }

    private function resolveDisplayValueFromModel(): ?string
    {
        if (empty($this->value) || empty($this->displayModelClass) || empty($this->displayAttribute)) {
            return null;
        }

        $modelClass = $this->resolveModelClass();

        if (!$modelClass || !class_exists($modelClass)) {
            Log::warning("ComboboxTable model '{$this->displayModelClass}' not found.");
            return null;
        }

        if (!is_subclass_of($modelClass, Model::class)) {
            Log::warning("ComboboxTable model '{$modelClass}' is not an Eloquent model.");
            return null;
        }

        try {
            /** @var \Illuminate\Database\Eloquent\Model|null $record */
            $record = $modelClass::query()->find($this->value);

            if (!$record) {
                return null;
            }

            return data_get($record, $this->displayAttribute);
        } catch (\Throwable $e) {
            Log::error('ComboboxTable resolveDisplayValueFromModel failed', [
                'model' => $modelClass,
                'value' => $this->value,
                'attribute' => $this->displayAttribute,
                'message' => $e->getMessage(),
            ]);

            return null;
        }
    }

    public function showComboboxTable(): void
    {
        $component = $this->comboboxTableContent;

        $parameters = $component['parameters'] ?? [];
        $parameters['htmlId'] = $this->htmlId;
        $parameters['selectedValue'] = $this->value;
        $parameters['selectedLabel'] = $this->displayValue;

        $component['parameters'] = $parameters;

        $this->dispatch(
            'combobox-table:show',
            htmlId: $this->htmlId,
            component: $component
        );
    }

    public function setSelectedValue($payload = null): void
    {
        if (!$payload || !is_array($payload)) {
            return;
        }

        if (($payload['htmlId'] ?? null) !== $this->htmlId) {
            return;
        }

        $this->value = $payload['value'] ?? null;
        $this->displayValue = $payload['label'] ?? null;

        if ($this->displayValue === null) {
            $this->displayValue = $this->resolveDisplayValueFromModel();
        }

        $this->dispatch('combobox-table:close');
    }

    public function render()
    {
        return view('livewire.core.combobox-table');
    }
}
