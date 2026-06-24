<?php

namespace App\Livewire\Core;

use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Livewire\Component;

class TreeRadio extends Component
{
    public array $data = [];
    public string $name = 'radio';
    public string $event = 'tree-radio-selected';

    public function select($value): void
    {
        $this->dispatch($this->event, value: $value, name: $this->name);
    }

    public function renderTree(): HtmlString
    {
        return new HtmlString(
            '<div class="branch__container">' . $this->renderBranches($this->data) . '</div>'
        );
    }

    protected function renderBranches(array $nodes): string
    {
        $html = '';

        foreach ($nodes as $node) {
            $html .= $this->renderBranch($node);
        }

        return $html;
    }

    protected function renderBranch(array $node): string
    {
        $hasChildren = !empty($node['children'] ?? []);
        $value = $node['value'] ?? null;
        $label = $node['label'] ?? '';
        $inputId = $node['id'] ?? md5($this->name . '-' . ($value ?? Str::uuid()));

        $html = '<div class="branch">';
        $html .= '<div class="branch__row">';

        $html .= '<div class="radio__input">';
        $html .= '<input '
            . 'type="radio" '
            . 'id="' . e($inputId) . '" '
            . 'name="' . e($this->name) . '" '
            . 'value="' . e($value) . '" '
            . 'wire:change="select(\'' . e((string) $value) . '\')" '
            . '/>';

        $html .= '<label for="' . e($inputId) . '">';
        $html .= e($label);
        $html .= '</label>';
        $html .= '</div>';

        $html .= '<button class="branch__button" type="button">';
        $html .= e($label);
        $html .= '<span class="caret"><i class="fa-solid fa-caret-down"></i></span>';
        $html .= '</button>';

        $html .= '</div>';

        if ($hasChildren) {
            $html .= '<div class="branch__container">';
            $html .= $this->renderBranches($node['children']);
            $html .= '</div>';
        }

        $html .= '</div>';

        return $html;
    }

    public function render()
    {
        return view('livewire.core.tree-radio');
    }
}
