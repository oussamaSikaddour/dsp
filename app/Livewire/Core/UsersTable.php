<?php

namespace App\Livewire\Core;

use App\Models\Image;
use App\Models\User;
use App\Traits\Core\Common\TableTrait;
use App\Traits\Core\Common\TextAndPdfTrait;
use App\Traits\Core\Web\ResponseTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

class UsersTable extends Component
{
    use WithPagination, TableTrait, WithFileUploads, ResponseTrait, TextAndPdfTrait;

    #[Url] public string $name = '';
    #[Url] public string $fullName = '';
    #[Url] public ?string $email = null;

    public ?bool $isForSuperAdmin = null;
    public ?int $establishmentId = null;
    public ?int $managerableId = null;
    public ?string $managerableType = null;

    public string $updateUserBtnTitle = '';
    public string $local = 'fr';

    protected array $filterable = [
        'name',
        'fullName',
        'email',
    ];

    protected array $validationRules = [
        'name'     => ['nullable', 'string', 'max:255'],
        'fullName' => ['nullable', 'string', 'max:255'],
        'email'    => ['nullable', 'string', 'email', 'max:255'],
    ];

    public function mount(): void
    {
        $this->local = app()->getLocale();
    }

    public function resetFilters(): void
    {
        $this->reset([
            'name',
            'fullName',
            'email',
        ]);

        $this->resetPage();
    }

    #[Computed]
    public function users()
    {
        return User::query()
            ->select([
                'id',
                'name',
                'first_name',
                'last_name',
                'email',
                'created_at',
                'establishment_id',
                'managerable_id',
                'managerable_type',
            ])
            ->withExists([
                'roles as is_super_admin' => function ($query) {
                    $query->where('slug', 'super_admin');
                }
            ])
            ->when($this->establishmentId, function ($query) {
                $query->where('establishment_id', $this->establishmentId);
            })
            ->when($this->name, function ($query) {
                $query->where('name', 'like', "%{$this->name}%");
            })
            ->when($this->fullName, function ($query) {
                $query->whereRaw(
                    "CONCAT(last_name, ' ', first_name) like ?",
                    ["%{$this->fullName}%"]
                );
            })
            ->when($this->managerableId && $this->managerableType, function ($query) {
                $query->where('managerable_id', $this->managerableId)
                      ->where('managerable_type', $this->managerableType);
            })
            ->when($this->email, function ($query) {
                $query->where('email', 'like', "%{$this->email}%");
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage)
            ->through(function ($user) {
                $user->fullName = trim($user->last_name . ' ' . $user->first_name);
                return $user;
            });
    }

    public function updated(string $property): void
    {
        if ($property === 'excelFile') {

            $errorsFileData = $this->whenExcelFileUploaded(
                "Core\UsersImport",
                __('tables.users.excel.upload.success'),
                [
                    $this->managerableId,
                    $this->managerableType,
                    $this->establishmentId
                ]
            );

            if (is_array($errorsFileData)) {
                $this->dispatch('errors-file-data', errorsFileData: $errorsFileData);
            }
        }

        if (in_array($property, $this->filterable) || $property === 'perPage') {
            $this->resetPage();
        }

        if (array_key_exists($property, $this->validationRules)) {
            try {
                $this->validateOnly($property, $this->validationRules);
            } catch (ValidationException $e) {
                $this->dispatch('open-errors', $e->validator->errors()->all());
            }
        }
    }

    #[On('errors-file-data')]
    public function downloadUsersErrorsTextFile($errorsFileData)
    {
        return $this->streamFileDownload(
            $errorsFileData['filePath'],
            $errorsFileData['fileName']
        );
    }

    public function generateEmptyUsersExcel()
    {
        return $this->generateEmptyExcelWithHeaders(
            "personnelVide",
            [
                'Nom (français)',
                'Prénom (français)',
                'Nom (Arabic)',
                'Prénom (Arabic)',
                'E-mail',
            ]
        );
    }

    public function generateUsersExcel()
    {
        return $this->generateExcel(
            fn () => $this->users()->map(fn ($user) => [
                __("tables.users.name") => $user->name,
                __("tables.users.full_name") => $user->fullName,
                __("tables.users.email") => $user->email,
                __("tables.users.registration_date") =>
                    $user->created_at->format('d-m-Y'),
            ])->toArray(),
            "users"
        );
    }



public function openDeleteUserDialog(int $userId): void
{
    $user = User::findOrFail($userId);

    $key = 'delete.user';

    $this->dispatch('open-dialog', [
        'question' => $key,

        'details' => [
            $key,
            $user->name,
        ],

        'actionEvent' => [
            'event' => 'delete-user',
            'parameters' => $userId,
        ],
    ]);
}

    #[On("delete-user")]
    public function deleteUser(int $userId): void
    {
        try {
            $user = User::findOrFail($userId);

            // 🔒 BLOCK LAST SUPER ADMIN DELETE
            if ($user->isSuperAdmin()) {

                $superAdminCount = User::superAdmins()->count();

                if ($superAdminCount <= 1) {
                    $this->dispatch(
                        'open-errors',
                        __('You cannot delete the last super admin.')
                    );
                    return;
                }
            }

            $images = Image::where([
                ['imageable_id', $user->id],
                ['imageable_type', User::class],
            ])->get();

            if ($images->isNotEmpty()) {
                $this->deleteImages($images);
            }

            $user->delete();

        } catch (\Exception $e) {
            Log::error('Error deleting user: ' . $e->getMessage());

            $this->dispatch(
                'open-errors',
                __('forms.common.errors.default')
            );
        }
    }

    public function render()
    {
        return view('livewire.core.users-table');
    }
}
