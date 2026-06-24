<?php

namespace App\Livewire\Core;

use Livewire\Component;

final class TinyMceTextArea extends Component
{
    public string $content = '';
    public string $htmlId = '';
    public string $contentUpdatedEvent = 'content-updated';
    public bool $viewOnly = false;

    public function mount(): void
    {
        $this->dispatch('initialize-tiny-mce');
    }

    /**
     * IMPORTANT: allow mixed input (TinyMCE may send null)
     */
    public function setContent($value): void
    {
        if ($this->viewOnly) {
            return;
        }

        // normalize null/undefined safely
        $this->content = $value ?? '';

        $this->dispatch($this->contentUpdatedEvent, $this->content);
    }

    public function render()
    {
        return view('livewire.core.tiny-mce-text-area');
    }
}
