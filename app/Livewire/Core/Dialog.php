<?php

namespace App\Livewire\Core;

use Livewire\Attributes\On;
use Livewire\Component;

final class Dialog extends Component
{
    public bool $isOpen = false;

    public string $question = '';

    /** @var array<int, mixed> */
    public array $details = [];

    /** @var array{event?: string, parameters?: mixed} */
    public array $actionEvent = [];

    public string $questionDetails = '';

    public bool $needsInertSync = false;

    private const BASE_KEY = 'dialogs.confirmation.';

    #[On('open-dialog')]
    public function openDialog(array $data = []): void
    {
        $this->isOpen = true;

        $this->question = $this->resolveTitle($data['question'] ?? '');

        $this->details = (array) ($data['details'] ?? []);
        $this->actionEvent = (array) ($data['actionEvent'] ?? []);

        $this->questionDetails = '';

        if (count($this->details) === 2) {
            [$key, $attribute] = $this->details;

            $this->questionDetails = $this->resolveQuestionDetails(
                (string) $key,
                $attribute
            );
        }

        $this->needsInertSync = true;
    }

    public function closeDialog(): void
    {
        $this->isOpen = false;

        $this->question = '';
        $this->details = [];
        $this->actionEvent = [];
        $this->questionDetails = '';

        $this->needsInertSync = true;
    }

    public function confirmAction(): void
    {
        $event = $this->actionEvent['event'] ?? null;

        if (!is_string($event) || $event === '') {
            return;
        }

        $this->dispatch($event, $this->actionEvent['parameters'] ?? []);

        $this->closeDialog();
    }

    public function rendered(): void
    {
        if (!$this->needsInertSync) {
            return;
        }

        $this->needsInertSync = false;

        $this->dispatch('dialog-sync-inert');
    }

    /**
     * TITLE resolver
     */
    private function resolveTitle(string $key): string
    {
        if ($key === '') {
            return '';
        }

        return __('dialogs.title.' . $key);
    }

    /**
     * QUESTION resolver (NO mapping array anymore)
     */
    private function resolveQuestionDetails(string $key, string|array $attribute): string
    {
        if ($key === '') {
            return '';
        }

        $replacements = is_array($attribute)
            ? $attribute
            : ['attribute' => $attribute];

        return __(self::BASE_KEY . $key, $replacements);
    }

    public function render()
    {
        return view('livewire.core.dialog');
    }
}
