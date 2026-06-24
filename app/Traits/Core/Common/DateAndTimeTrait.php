<?php

namespace App\Traits\Core\Common;

use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Cache;

trait DateAndTimeTrait
{
    /*
    |---------------------------------------
    | NORMALIZE HELPERS
    |---------------------------------------
    */

    /**
     * Normalize working days (ensures ints, removes invalid values).
     */
    protected function normalizeWorkingDays(array $workingDays): array
    {
        return array_values(array_unique(array_filter(
            array_map('intval', $workingDays),
            fn ($day) => $day >= 0 && $day <= 6
        )));
    }

    /**
     * Normalize days off (ensure valid dates only).
     */
    protected function normalizeDaysOff(array $daysOff): array
    {
        return array_values(array_filter($daysOff, function ($date) {
            return !empty($date) && strtotime($date) !== false;
        }));
    }

    /*
    |---------------------------------------
    | WORK DURATION
    |---------------------------------------
    */

    protected function calculateWorkDurationInHours(string $startTime, string $endTime): ?float
    {
        $cacheKey = "work_duration_{$startTime}_{$endTime}";

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($startTime, $endTime) {

            $start = DateTime::createFromFormat('H:i', $startTime);
            $end = DateTime::createFromFormat('H:i', $endTime);

            if (!$start || !$end) {
                return null;
            }

            if ($start > $end) {
                $end->modify('+1 day');
            }

            $diff = $start->diff($end);

            return round($diff->h + ($diff->i / 60), 2);
        });
    }

    /*
    |---------------------------------------
    | WORKING DAY CHECK (CORE LOGIC)
    |---------------------------------------
    */

    protected function isWorkingDay(string $date, array $workingDays): bool
    {
        try {
            $dayOfWeek = Carbon::parse($date)->dayOfWeek;
        } catch (\Throwable $e) {
            return false;
        }

        return in_array($dayOfWeek, $this->normalizeWorkingDays($workingDays), true);
    }

    protected function isAvailableWorkingDay(
        string $date,
        array $workingDays,
        array $daysOff = []
    ): bool {
        try {
            $carbon = Carbon::parse($date);
        } catch (\Throwable $e) {
            return false;
        }

        $daysOff = $this->normalizeDaysOff($daysOff);

        if (in_array($carbon->toDateString(), $daysOff, true)) {
            return false;
        }

        return in_array(
            $carbon->dayOfWeek,
            $this->normalizeWorkingDays($workingDays),
            true
        );
    }

    /*
    |---------------------------------------
    | TOTAL DAYS (OPTIMIZED)
    |---------------------------------------
    */

    protected function getTotalDays(
        string $startDate,
        string $endDate,
        array $workingDays = [],
        bool $onlyWorkingDays = false
    ): int {
        $workingDays = $this->normalizeWorkingDays($workingDays);

        $cacheKey = 'total_days_' . md5(
            $startDate . $endDate . json_encode($workingDays) . (int)$onlyWorkingDays
        );

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($startDate, $endDate, $workingDays, $onlyWorkingDays) {

            try {
                $start = Carbon::parse($startDate);
                $end = Carbon::parse($endDate);
            } catch (\Throwable $e) {
                return 0;
            }

            if ($start->gt($end)) {
                return 0;
            }

            if (!$onlyWorkingDays || empty($workingDays)) {
                return $start->diffInDays($end) + 1;
            }

            $count = 0;

            for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                if (in_array($date->dayOfWeek, $workingDays, true)) {
                    $count++;
                }
            }

            return $count;
        });
    }

    /*
    |---------------------------------------
    | DATE FORMATTER (LIGHTWEIGHT)
    |---------------------------------------
    */

    public function parseDate(?string $date, string $format = 'Y-m-d'): ?string
    {
        if (!$date) {
            return null;
        }

        try {
            return Carbon::parse($date)->format($format);
        } catch (\Throwable $e) {
            return null;
        }
    }
}
