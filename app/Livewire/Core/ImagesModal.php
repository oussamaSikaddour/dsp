<?php

namespace App\Livewire\Core;

use App\Livewire\Forms\Core\Image\AddForm;
use App\Livewire\Forms\Core\Image\UpdateForm;
use App\Models\Image;
use App\Traits\Core\Common\GeneralTrait;
use App\Traits\Core\Common\ModelImageTrait;
use App\Traits\Core\Common\TableTrait;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class ImagesModal extends Component
{
    use TableTrait, GeneralTrait,WithFileUploads,ModelImageTrait;

    public AddForm $addForm;
    public UpdateForm $updateForm;
    public ?Image $image = null;

    public ?int $imageId = null;
    public ?int $imageableId = null;
    public string $imageableType = '';
    public ?int $selectedChoice = null;
    public string $form = 'addForm';
    public string $locale = 'fr';
    public $temporaryImageUrl ;


        #[Computed]
    public function formEntity()
    {
        return $this->imageId ? $this->updateForm : $this->addForm;
    }

    /**
     * Reset form fields and prepare for adding.
     */
    public function resetForm(): void
    {
        $this->form = 'addForm';
        $this->imageId = null;
        $this->selectedChoice = null;


        $this->addForm->reset();
        $this->updateForm->reset();

        $this->addForm->fill([
            'imageable_id' => $this->imageableId,
            'imageable_type' => $this->imageableType,
        ]);
    }

    /**
     * Handle switching between add and update forms.
     */
    public function updatedSelectedChoice(): void
    {
        $this->imageId = $this->selectedChoice;

        // 🩹 Fixed wrong variable case: $this->ImageId → $this->imageId
        $this->form = $this->imageId ? 'updateForm' : 'addForm';

        if ($this->imageId) {
            $this->setImageForm($this->imageId);
        }
    }

    /**
     * Computed: list images for this entity.
     */
    #[Computed]
    public function images()
    {
        return Image::where('imageable_id', $this->imageableId)
            ->where('imageable_type', $this->imageableType)
            ->orderBy($this->sortBy, $this->sortDirection)
            ->get();
    }

    /**
     * Mount component.
     */
    public function mount(): void
    {
             $this->dispatch('init-tooltips');
        $this->locale = app()->getLocale();

        $this->resetForm();
    }

    /**
     * Set update form fields from Image.
     */
    public function setImageForm(int $imageId): void
    {
        try {
            $image = Image::where('imageable_id', $this->imageableId)
                ->where('imageable_type', $this->imageableType)
                ->findOrFail($imageId);

            $this->image = $image;

         $this->temporaryImageUrl = $this->image->url ;
            $this->updateForm->fill($this->image->only([
                'id', 'display_name', 'use_case','imageable_id','imageable_type'
            ]));
        } catch (\Exception $e) {
            Log::error('Error in setImageForm: ' . $e->getMessage());
            $this->dispatch('open-errors', __('forms.common.errors.default'));
        }
    }

    /**
     * Handle add or update.
     */
    public function handleSubmit(): void
    {
        $this->dispatch('form-submitted');

        // 🩹 Fixed variable names
        $response = $this->imageId
            ? $this->updateForm->save($this->image)
            : $this->addForm->save();

        if ($response['status']) {
            $this->dispatch('update-images-table');

            if ($this->form === 'addForm') {
                $this->resetForm();
                 $this->temporaryImageUrl=null;
            }

            $this->dispatch('open-toast', $response['message']);
        } else {
            $this->dispatch('open-errors', $response['errors']);
        }
    }

    /**
     * Open delete confirmation dialog.
     */
public function openDeleteImageDialog(int $imageId): void
{
    try {
        $image = Image::where('imageable_id', $this->imageableId)
            ->where('imageable_type', $this->imageableType)
            ->findOrFail($imageId);

        $name = $image->display_name ?? '';

        $key = "delete.image";
        $data = [
            'question' => $key,
            'details' => [$key, $name],
            'actionEvent' => [
                'event' => 'delete-image',
                'parameters' => ['imageId' => $imageId],
            ],
        ];

        $this->dispatch('open-dialog', $data);
    } catch (\Exception $e) {
        Log::error('Error in openDeleteImageDialog: ' . $e->getMessage());
        $this->dispatch('open-errors', __('forms.common.errors.default'));
    }
}

#[On('delete-image')]
public function deleteImg(array $params): void
{
    try {
        $imageId = $params['imageId'] ?? null;

        if (!$imageId) {
            throw new \Exception('Image ID not provided');
        }

        $image = Image::where('imageable_id', $this->imageableId)
            ->where('imageable_type', $this->imageableType)
            ->findOrFail($imageId);

        $this->deleteImage($image);
        $this->dispatch('update-images-table');
        $this->temporaryImageUrl = null;
    } catch (\Exception $e) {
        Log::error('Error in deleteImage: ' . $e->getMessage());
        $this->dispatch('open-errors', __('forms.common.errors.default'));
    }
}


        public function updated($property)
    {
        if (in_array($property, ['addForm.real_image', 'updateForm.real_image'])){
            $this->updateTemporaryImageUrl();
        }

    }

        protected function updateTemporaryImageUrl()
    {
        try {
            $this->temporaryImageUrl = $this->formEntity->real_image->temporaryUrl();


        } catch (\Exception $e) {
            $this->dispatch('open-errors', __('forms.common.errors.img.not_img'));
        }
    }

    public function render()
    {

        return view('livewire.core.images-modal');
    }
}
