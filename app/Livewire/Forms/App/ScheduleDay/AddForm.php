<?php

namespace App\Livewire\Forms\App\ScheduleDay;

use App\Models\ScheduleDay;
use App\Traits\Core\Web\ResponseTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Livewire\Form;

class AddForm extends Form
{
    use ResponseTrait;

    public ?int $schedule_id = null;
    public ?string $day_at = null;

    public ?int $appointment_duration = 30;

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
            'schedule_id' => ['required', 'exists:schedules,id'],
            'day_at' => ['required', 'date'],

            'appointment_duration' => ['required', 'integer', 'in:15,30,45,60'],

            'working_periods' => ['required', 'array'],
            'working_periods.*.start' => ['required', 'date_format:H:i'],
            'working_periods.*.end'   => ['required', 'date_format:H:i'],

            'appointments_locations' => ['required', 'array'],
            'appointments_locations.*.location_id' => ['required', 'integer', 'exists:establishments,id'],
            'appointments_locations.*.capacity' => ['required', 'integer', 'min:1'],
        ];
    }

    /*
    |---------------------------------------
    | VALIDATION ATTRIBUTES (FIXED)
    |---------------------------------------
    */
    public function validationAttributes(): array
    {
        return [
            'schedule_id' => __('schedule_day.schedule_id'),
            'day_at' => __('schedule_day.day_at'),
            'appointment_duration' => __('schedule_day.appointment_duration'),

            'working_periods' => __('schedule_day.working_periods'),
            'appointments_locations' => __('schedule_day.appointments_locations'),
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
            'working_periods.*.start.required' => __('forms.schedule_day.errors.start_required'),
            'working_periods.*.end.required'   => __('forms.schedule_day.errors.end_required'),

            'appointments_locations.*.location_id.required' => __('forms.schedule_day.errors.location_required'),
            'appointments_locations.*.capacity.required' => __('forms.schedule_day.errors.capacity_required'),
        ];
    }

    /*
    |---------------------------------------
    | VALIDATION WRAPPER
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

            $formatted = [];
            $failedRules = $validator->failed();

            foreach ($validator->errors()->toArray() as $field => $messages) {

                // WORKING PERIODS
                if (preg_match('/working_periods\.(\d+)\.(start|end)/', $field, $m)) {

                    $index = (int) $m[1] + 1;
                    $attribute = $m[2];

                    $formatted[$field] = [
                        __("forms.schedule_day.errors.working_periods.{$attribute}", [
                            'item_number' => $index,
                        ])
                    ];

                    continue;
                }

                // LOCATIONS
                if (preg_match('/appointments_locations\.(\d+)\.(location_id|capacity)/', $field, $m)) {

                    $index = (int) $m[1] + 1;
                    $attribute = $m[2];

                    $ruleType = array_key_first($failedRules[$field] ?? []);
                    $ruleType = strtolower($ruleType);

                    $formatted[$field] = [
                        __("forms.schedule_day.errors.locations.{$attribute}_{$ruleType}", [
                            'item_number' => $index,
                        ])
                    ];

                    continue;
                }

                $formatted[$field] = $messages;
            }

            throw ValidationException::withMessages($formatted);
        }

        return $validator->validated();
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

            ScheduleDay::create($data);

            return $this->response(
                true,
                message: __('forms.schedule_day.responses.add_success')
            );

        } catch (ValidationException $e) {

            return $this->response(false, errors: $e->validator->errors()->all());

        } catch (\Throwable $e) {

            Log::error('ScheduleDay Add Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return $this->response(false, errors: __('forms.common.errors.default'));
        }
    }
}
