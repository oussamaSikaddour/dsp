<?php

$months = [
    "en" => [
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December',
    ],
    "fr" => [
        1 => 'Janvier',
        2 => 'Février',
        3 => 'Mars',
        4 => 'Avril',
        5 => 'Mai',
        6 => 'Juin',
        7 => 'Juillet',
        8 => 'Août',
        9 => 'Septembre',
        10 => 'Octobre',
        11 => 'Novembre',
        12 => 'Décembre',
    ],
    "ar" => [
        1 => 'يناير',
        2 => 'فبراير',
        3 => 'مارس',
        4 => 'أبريل',
        5 => 'مايو',
        6 => 'يونيو',
        7 => 'يوليو',
        8 => 'أغسطس',
        9 => 'سبتمبر',
        10 => 'أكتوبر',
        11 => 'نوفمبر',
        12 => 'ديسمبر',
    ],
];

$monthsOptions = [
    "en" => ['' => '--- Choose a month ---'] + $months["en"],
    "fr" => ['' => '--- Choisir un mois ---'] + $months["fr"],
    "ar" => ['' => '--- اختر شهرًا ---'] + $months["ar"],
];

// reusable years array
$years = array_combine(
    range(now()->year, 2050),
    range(now()->year, 2050)
);

return [

    "YEARS" => $years,

    // ✅ NEW: YEAR OPTIONS (localized)
    "YEAR_OPTIONS" => [
        "en" => ['' => '--- Choose a year ---'] + $years,
        "fr" => ['' => '--- Choisir une année ---'] + $years,
        "ar" => ['' => '--- اختر سنة ---'] + $years,
    ],

    "INAUGURAL_YEARS" => array_combine(
        range(1962, now()->year),
        range(1962, now()->year)
    ),

    "MONTHS" => $months,

    "MONTHS_OPTIONS" => $monthsOptions,

    "HOURS" => collect(range(0, 23))
        ->flatMap(function ($hour) {
            return [
                sprintf('%02d:00', $hour),
                sprintf('%02d:30', $hour),
            ];
        })
        ->mapWithKeys(fn ($time) => [$time => $time])
        ->toArray(),

    "WEEK_DAYS" => [
        "en" => [
            0 => "Sunday",
            1 => "Monday",
            2 => "Tuesday",
            3 => "Wednesday",
            4 => "Thursday",
            5 => "Friday",
            6 => "Saturday",
        ],
        "fr" => [
            0 => "Dimanche",
            1 => "Lundi",
            2 => "Mardi",
            3 => "Mercredi",
            4 => "Jeudi",
            5 => "Vendredi",
            6 => "Samedi",
        ],
        "ar" => [
            0 => "الأحد",
            1 => "الاثنين",
            2 => "الثلاثاء",
            3 => "الأربعاء",
            4 => "الخميس",
            5 => "الجمعة",
            6 => "السبت",
        ],
    ],

];
