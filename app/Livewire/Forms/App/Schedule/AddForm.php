<?php

namespace App\Livewire\Forms\App\Schedule;

use App\Models\Schedule;
use App\Traits\Core\Web\ResponseTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Livewire\Form;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class AddForm extends Form
{
    use ResponseTrait;

    public string $name_fr = '';
    public string $name_ar = '';
    public string $name_en = '';

    public ?string $description_fr = null;
    public ?string $description_ar = null;
    public ?string $description_en = null;

    public ?int $month = null;
    public ?int $year = null;
    public ?int $service_id = null;
    public ?int $opened_by = null;
    public ?int $appointment_duration = null;

    public array $working_days = [];
    public array $days_off = [];
    public array $working_periods = [];
    public array $appointments_locations = [];

    /*
    |---------------------------------------
    | RULES
    |---------------------------------------
    */
    public function rules(): array
    {
        return [
            'name_ar' => ['required', 'string', 'min:5', 'max:255'],
            'name_fr' => ['required', 'string', 'min:5', 'max:255'],
            'name_en' => ['required', 'string', 'min:5', 'max:255'],

            'description_fr' => ['nullable', 'string', 'min:5', 'max:255'],
            'description_ar' => ['nullable', 'string', 'min:5', 'max:255'],
            'description_en' => ['nullable', 'string', 'min:5', 'max:255'],

            'year'  => ['required', 'integer', 'digits:4', 'between:2023,2050'],
            'month' => [
                'required',
                'integer',
                'between:1,12',
                Rule::unique('schedules', 'month')
                    ->where(
                        fn($query) => $query
                            ->where('year', $this->year)
                            ->where('service_id', $this->service_id)
                    ),
            ],

            'service_id' => ['required', 'exists:services,id'],
            'appointment_duration' => [
                'required',
                'integer',
                'in:15,30,45,60',
            ],
            'opened_by'  => ['required', 'exists:users,id'],

            'working_days' => ['required', 'array'],
            'working_days.*' => ['integer', 'between:0,6'],

            'days_off' => ['nullable', 'array'],
            'days_off.*' => ['date'],

            'working_periods' => ['required', 'array'],
            'working_periods.*.start' => ['required', 'date_format:H:i'],
            'working_periods.*.end'   => ['required', 'date_format:H:i'],

            'appointments_locations' => ['nullable', 'array'],
            'appointments_locations.*.location_id' => ['required', 'integer', 'exists:establishments,id'],
            'appointments_locations.*.capacity' => ['required', 'integer', 'min:1'],
        ];
    }

    /*
    |---------------------------------------
    | MESSAGES
    |---------------------------------------
    */
    public function messages(): array
    {
        return [
            'working_periods.*.start.required' => __('forms.schedule.errors.start_required'),
            'working_periods.*.end.required'   => __('forms.schedule.errors.end_required'),

            'appointments_locations.*.location_id.required' => __('forms.schedule.errors.location_required'),
            'appointments_locations.*.capacity.required' => __('forms.schedule.errors.capacity_required'),
        ];
    }

    /*
    |---------------------------------------
    | ATTRIBUTES
    |---------------------------------------
    */
    public function validationAttributes(): array
    {
        return [
            'name_fr' => __('forms.schedule.name_fr'),
            'name_ar' => __('forms.schedule.name_ar'),
            'name_en' => __('forms.schedule.name_en'),

            'description_fr' => __('forms.schedule.description_fr'),
            'description_ar' => __('forms.schedule.description_ar'),
            'description_en' => __('forms.schedule.description_en'),
            'appointment_duration' => __('forms.schedule.appointment_duration'),

            'year' => __('forms.schedule.year'),
            'month' => __('forms.schedule.month'),

            'service_id' => __('forms.schedule.service_id'),
            'opened_by' => __('forms.schedule.opened_by'),

            'working_days' => __('forms.schedule.working_days'),
            'days_off' => __('forms.schedule.days_off'),
            'working_periods' => __('forms.schedule.working_periods'),
            'appointments_locations' => __('forms.schedule.appointments_locations'),
        ];
    }

    /*
    |---------------------------------------
    | VALIDATION WRAPPER (COMMAND STYLE)
    |---------------------------------------
    */
    protected function validateForm(): array
    {
        $validator = Validator::make(
            $this->all(),
            $this->rules(),
            $this->messages(),
            $this->validationAttributes()
        );

        if ($validator->fails()) {

            $formattedErrors = [];

            $failedRules = $validator->failed();

            foreach ($validator->errors()->toArray() as $field => $messages) {

                /*
                |-------------------------
                | WORKING PERIODS
                |-------------------------
                */
                if (preg_match('/working_periods\.(\d+)\.(start|end)/', $field, $m)) {

                    $index = (int) $m[1] + 1;
                    $attribute = $m[2];

                    $formattedErrors[$field] = [
                        __("forms.schedule.errors.working_periods.{$attribute}", [
                            'item_number' => $index,
                        ])
                    ];

                    continue;
                }

                /*
                |-------------------------
                | APPOINTMENTS LOCATIONS
                |-------------------------
                */
                if (preg_match('/appointments_locations\.(\d+)\.(location_id|capacity)/', $field, $m)) {

                    $index = (int) $m[1] + 1;
                    $attribute = $m[2];

                    // detect rule type (required, integer, min, exists...)
                    $ruleType = array_key_first($failedRules[$field] ?? []);

                    $ruleType = strtolower($ruleType);

                    $formattedErrors[$field] = [
                        __("forms.schedule.errors.locations.{$attribute}_{$ruleType}", [
                            'item_number' => $index,
                        ])
                    ];

                    continue;
                }

                /*
                |-------------------------
                | DEFAULT
                |-------------------------
                */
                $formattedErrors[$field] = $messages;
            }

            throw ValidationException::withMessages($formattedErrors);
        }

        return $validator->validated();
    }

    /*
    |---------------------------------------
    | CLEAN DAYS OFF
    |---------------------------------------
    */
    private function cleanDaysOff(array $days): array
    {
        return collect($days)
            ->filter()
            ->map(fn($date) => Carbon::parse($date)->toDateString())
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    /*
    |---------------------------------------
    | SAVE
    |---------------------------------------
    */
    public function save()
    {
        try {
            $data = $this->validateForm();

            $data['days_off'] = $this->cleanDaysOff($data['days_off'] ?? []);

            Schedule::create($data);

            return $this->response(
                true,
                message: __('forms.schedule.responses.add_success')
            );
        } catch (ValidationException $e) {

            return $this->response(false, errors: $e->validator->errors()->all());
        } catch (\Throwable $e) {

            Log::error('Schedule Add Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return $this->response(false, errors: __('forms.common.errors.default'));
        }
    }
}
