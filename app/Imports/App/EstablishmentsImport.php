<?php

namespace App\Imports\App;

use App\Models\Daira;
use App\Models\Establishment;
use App\Rules\Core\LandLineNumberExist;
use App\Rules\Core\ValidDaira;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class EstablishmentsImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    /** @var array<string> Accumulated validation errors with line numbers */
    private array $errors = [];

    /** @var int Tracks current overall line number across chunks */
    private int $overallLineNumber = 1;

    /** @var string Wilaya code (default '13') */
    private string $wilayaCode;

    /** @var array<string, int> Mapping: daira name => daira ID */
    private array $dairaNameToId = [];

    /**
     * Constructor: preload dairas for the given wilaya.
     */
    public function __construct(string $wilayaCode = '13')
    {
        $this->wilayaCode = $wilayaCode;

        // Load all daira names mapped to their IDs, in all locales
        $this->dairaNameToId = Daira::query()
            ->select(['dairates.id', 'dairates.designation_ar', 'dairates.designation_fr', 'dairates.designation_en'])
            ->join('wilayates', 'wilayates.id', '=', 'dairates.wilaya_id')
            ->where('wilayates.code', $wilayaCode)
            ->get()
            ->flatMap(function ($daira) {
                return [
                    mb_strtolower($daira->designation_ar) => $daira->id,
                    mb_strtolower($daira->designation_fr) => $daira->id,
                    mb_strtolower($daira->designation_en) => $daira->id,
                ];
            })
            ->toArray();
    }

    /**
     * Process each chunk of rows.
     */
    public function collection(Collection $rows): void
    {
        foreach ($rows as $index => $row) {
            $lineNumber = $this->overallLineNumber + $index + 1;

            $cleanRow = $this->trimRowValues($row->toArray());

            $validator = $this->getValidator($cleanRow);

            if ($validator->fails()) {
                $this->addValidationErrors($validator->errors()->all(), $lineNumber);
                continue;
            }

            $this->insertEstablishment($cleanRow);
        }

        $this->overallLineNumber += $rows->count();

        if (!empty($this->errors)) {
            throw new \Exception($this->getFormattedErrors());
        }
    }

    /**
     * Remove extra spaces from all string values.
     */
    private function trimRowValues(array $row): array
    {
            return array_map(
        fn($value) => is_string($value) ? mb_strtolower(trim($value)) : $value,
        $row
    );
    }

    /**
     * Build the validator with rules.
     */
    private function getValidator(array $row)
    {
        $unique = fn($column) =>
            Rule::unique('establishments', $column)->whereNull('deleted_at');

        return Validator::make($row, [
            'acronym'      => ['required', 'string', 'max:10', $unique('acronym')],
            'nom_francais' => ['required', 'string', 'min:5', 'max:255', $unique('name_fr')],
            'nom_arabe'    => ['required', 'string', 'min:5', 'max:255', $unique('name_ar')],
            'nom_anglais'  => ['required', 'string', 'min:5', 'max:255', $unique('name_en')],
            'email'        => ['nullable', 'email', 'max:255', $unique('email')],
            'telephone'    => ['required', 'digits:9', new LandLineNumberExist(new Establishment())],
            'fax'          => ['nullable', 'digits:9', new LandLineNumberExist(new Establishment())],
            'lieu_de_consultations'  => ['nullable', 'string', Rule::in(['oui', 'non',''])],
            'longitude'    => [
                'required', 'numeric', 'between:-180,180',
                Rule::unique('establishments')->where('latitude', $row['latitude'] ?? null)->whereNull('deleted_at'),
            ],
            'latitude'     => [
                'required', 'numeric', 'between:-90,90',
                Rule::unique('establishments')->where('longitude', $row['longitude'] ?? null)->whereNull('deleted_at'),
            ],
            'daira'        => ['required', 'string', new ValidDaira($this->wilayaCode)],
        ],
        [],
        [
            'acronym'      => __('imports.establishments.acronym'),
            'nom_francais' => __('imports.establishments.name_fr'),
            'nom_arabe'    => __('imports.establishments.name_ar'),
            'nom_anglais'  =>__('imports.establishments.name_en'),
            'email'        => __('imports.establishments.email'),
            'telephone'    => __('imports.establishments.tel'),
            'fax'          => __('imports.establishments.fax'),
            'lieu_de_consultations'  =>__('imports.establishments.appointments_location'),
            'longitude'    => __('imports.establishments.longitude'),
            'latitude'     => __('imports.establishments.latitude'),
            'daira'        => __('imports.establishments.daira'),

        ]);
    }

    /**
     * Insert establishment into DB with resolved daira_id.
     */
    private function insertEstablishment(array $row): void
    {
        $dairaId = $this->resolveDairaId($row['daira']) ?? $row['daira'];

            $types = [];
     if (strtolower($row['lieu_de_consultations'] ?? '') === 'oui') {
        $types[] = 'appointment_locations';
     }
        Establishment::create([
            'acronym'   => $row['acronym'],
            'name_fr'   => $row['nom_francais'],
            'name_ar'   => $row['nom_arabe'],
            'name_en'   => $row['nom_anglais'],
            'email'     => $row['email'] ?? null,
            'tel'       => $row['telephone'],
            'fax'       => $row['fax'] ?? null,
            'longitude' => $row['longitude'],
            'latitude'  => $row['latitude'],
            'daira_id'  => $dairaId,
              'daira_id'  => $dairaId,
            'types'     => $types,
        ]);
    }

    /**
     * Try to find daira ID by name in any locale.
     */
    private function resolveDairaId(string $dairaName): ?int
    {
        return $this->dairaNameToId[mb_strtolower($dairaName)] ?? null;
    }

    /**
     * Add formatted validation errors.
     */
    private function addValidationErrors(array $errors, int $lineNumber): void
    {
        foreach ($errors as $error) {
            $this->errors[] = __("imports.line_number_error", ['number' => $lineNumber]) . " : " . $error;
        }
    }

    /**
     * Format all errors into one string.
     */
    private function getFormattedErrors(): string
    {
        return implode("\n", $this->errors);
    }

    /**
     * Define chunk size.
     */
    public function chunkSize(): int
    {
        return 1000;
    }
}
