<?php

namespace App\Imports\App;

use App\Models\FieldSpecialty;
use App\Models\Service;
use App\Models\User;
use App\Rules\Core\LandLineNumberExist;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ServicesImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    protected array $errors = [];
    protected int $overallLineNumber = 1;
    protected array $services = [];
    protected array $specialtiesCache = [];
    protected array $serviceTypesOptions = [];
    protected array $personnelCache = [];
    protected ?int $establishmentId = null;

    public function __construct(?int $establishmentId = null)
    {
        $this->establishmentId = $establishmentId;
        // specialty_name => id
        $this->specialtiesCache = FieldSpecialty::pluck('id', 'designation_fr')->mapWithKeys(function ($id, $name) {
            return [Str::lower(trim($name)) => $id];
        })->toArray();
        // localized service types
        $this->serviceTypesOptions = config('core.options.SERVICE_TYPE')['fr'] ?? [];
        $this->serviceTypesOptions = array_map('mb_strtolower', $this->serviceTypesOptions);
        // personnel name_fr => id (scoped to establishment)
        $this->personnelCache = User::query()
            ->where('establishment_id', $this->establishmentId)
            ->selectRaw("LOWER(CONCAT(last_name, ' ', first_name)) as full_name, id")
            ->pluck('id', 'full_name')
            ->toArray();
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            $lineNumber = $this->overallLineNumber + $index + 1;
            $cleanRow   = $this->trimRowValues($row->toArray());
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
            fn($value) => is_string($value) ? mb_strtolower(trim($value)) : $value,
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
        $uniqueRules = fn(string $column) => [
            'required',
            'string',
            'min:5',
            'max:255',
            Rule::unique('services', $column)
                ->where(fn($query) => $query->where('establishment_id', $this->establishmentId))
                ->whereNull('deleted_at'),
        ];

        return Validator::make(
            $row,
            [
                'nom_arabe'    => $uniqueRules('name_ar'),
                'nom_francais' => $uniqueRules('name_fr'),
                'nom_anglais'  => $uniqueRules('name_en'),
                'specialite' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        if (isset($this->specialtiesCache[$value])) {
                            return true;
                        }
                        foreach (array_keys($this->specialtiesCache) as $specName) {
                            if (Str::contains($specName, $value)
                                // || levenshtein($specName, $value) <= 3
                            ) {
                                return true;
                            }
                        }
                        $fail(__('imports.services.specialty_not_found', ['value' => $value]));
                    }
                ],
                'chef_de_service' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        $normalized = preg_replace('/\s+/', ' ', trim(mb_strtolower($value)));

                        if (!isset($this->personnelCache[$normalized])) {
                            $fail(
                                __('imports.services.head_service_not_found', [
                                    'value' => $value
                                ])
                            );
                        }
                    },
                ],
                'telephone'       => ['required', 'digits:9', new LandLineNumberExist(new Service())],
                'fax'             => ['nullable', 'digits:9', new LandLineNumberExist(new Service())],
                'type' => ['required', Rule::in(array_values($this->serviceTypesOptions))],
            ],
            [],
            [
                'nom_francais' => __('imports.attributes.services.name_fr'),
                'nom_anglais' => __('imports.attributes.services.name_en'),
                'nom_arabe' => __('imports.attributes.services.name_ar'),
                'telephone'     => __('imports.attributes.services.tel'),
                'fax'     => __('imports.attributes.services.fax'),
                'chef_de_service' => __('imports.attributes.services.head_service'),
                'specialite'    => __('imports.attributes.services.specialty'),
                'type'    => __('imports.attributes.services.type'),
            ]

        );
    }

    protected function addValidationErrors(array $errors, int $lineNumber): void
    {
        foreach ($errors as $error) {
            $this->errors[] = __("imports.line_number_error", ['number' => $lineNumber]) . " : " . $error;
        }
    }



    protected function prepareDataForBulkInsert(array $row): void
    {
        // Normalize specialty search
        $search = Str::lower(trim($row["specialite"] ?? ''));

        $specialtyId = collect($this->specialtiesCache)
            ->first(function ($value, $key) use ($search) {
                return Str::contains(Str::lower($key), $search);
            });

        $this->services[] = [
            "name_fr"            => $row["nom_francais"],
            "name_ar"            => $row["nom_arabe"],
            "name_en"            => $row["nom_anglais"],
            "specialty_id"       => $specialtyId,
            "head_of_service_id" => $this->personnelCache[$row["chef_de_service"]] ?? null,
            "tel"                => $row["telephone"],
            "fax"                => $row["fax"] ?? null,
            // store the internal key (e.g. "health") instead of the label (e.g. "Santé")
            "type"               => array_search(
                Str::lower(trim($row["type"])),
                array_map('strtolower', $this->serviceTypesOptions),
                true
            ) ?: null,
            "establishment_id"   => $this->establishmentId,
            "created_at"         => now(),
            "updated_at"         => now(),
        ];
    }

    protected function finalizeBulkInsert(): void
    {
        if (empty($this->services)) {
            return;
        }
        try {
            Service::insert($this->services);
        } catch (\Throwable $e) {
            Log::error("ServiceImport bulk insert error", [
                "message" => $e->getMessage(),
                "trace"   => $e->getTraceAsString()
            ]);
            $this->errors[] = __("imports.common.bulk_insert_error");
        } finally {
            $this->services = []; // always clear buffer
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
