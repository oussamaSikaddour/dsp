<?php

namespace App\Imports\Core;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    protected array $errors = [];
    protected int $overallLineNumber = 1;
    protected array $userRoles = [];

    protected static ?int $defaultRoleId = null;

    public function __construct(
        protected ?int $managerableId = null,
        protected ?string $managerableType = null,
        protected ?int $establishmentId = null,
    ) {}

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            $lineNumber = $this->overallLineNumber + $index + 1;

            $cleanRow = $this->trimRowValues($row->toArray());
            $this->processRow($cleanRow, $lineNumber);
        }

        $this->overallLineNumber += $rows->count();
        $this->finalizeBulkInsert();

        if ($this->hasErrors()) {
            throw new \Exception($this->getFormattedErrors());
        }
    }

    protected function trimRowValues(array $row): array
    {
        return array_map(
            fn($value) => is_string($value) ? trim($value) : $value,
            $row
        );
    }

    protected function processRow(array $row, int $lineNumber): void
    {
        $validator = $this->getValidator($row);

        if ($validator->fails()) {
            $this->addValidationErrors($validator->errors()->all(), $lineNumber);
            return;
        }

        $this->prepareDataForBulkInsert($row);
    }

    protected function getValidator(array $row)
    {
        return Validator::make(
            $row,
            [
                'nom' => ['required', 'string', 'min:3', 'max:255'],
                'prenom' => ['required', 'string', 'min:3', 'max:255'],

                'nom_dutilisateur' => [
                    'required',
                    'string',
                    'min:3',
                    'max:255',
                    Rule::unique('users', 'name')->whereNull('deleted_at'),
                ],

                'e_mail' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('users', 'email')->whereNull('deleted_at'),
                ],
            ],
            [],
            [
                'nom_dutilisateur' => __('imports.users.nom_d_utilisateur'),
                'e_mail' => __('imports.users.e_mail'),
            ]
        );
    }

    protected function addValidationErrors(array $errors, int $lineNumber): void
    {
        foreach ($errors as $error) {
            $this->errors[] =
                __("imports.line_number_error", ['number' => $lineNumber])
                . " : "
                . $error;
        }
    }

    protected function prepareDataForBulkInsert(array $row): void
    {
        $password = "12345678";

        $userData = [
            'last_name'  => $row['nom'],
            'first_name' => $row['prenom'],
            'name'       => $row['nom_dutilisateur'],
            'email'      => $row['e_mail'],
            'password'   => Hash::make($password),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // only add managerable if provided
        if (!empty($this->managerableId) && !empty($this->managerableType)) {
            $userData['managerable_id'] = $this->managerableId;
            $userData['managerable_type'] = $this->managerableType;
        }

        if (!empty($this->establishmentId) ) {
            $userData['establishment_id'] = $this->establishmentId;
        }

        $userId = User::insertGetId($userData);

        $this->userRoles[] = [
            'user_id' => $userId,
            'role_id' => $this->getDefaultRoleId(),
        ];
    }

    protected function getDefaultRoleId(): ?int
    {
        if (self::$defaultRoleId === null) {
            self::$defaultRoleId = Role::where(
                'slug',
                config('defaultRole.default_role_slug', 'user')
            )->value('id');
        }

        return self::$defaultRoleId;
    }

    protected function finalizeBulkInsert(): void
    {
        if (!empty($this->userRoles)) {
            DB::table('role_user')->insert($this->userRoles);
            $this->userRoles = [];
        }
    }

    protected function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    protected function getFormattedErrors(): string
    {
        return implode("\n", $this->errors);
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
