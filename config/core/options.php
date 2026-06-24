<?php

return [

    "STATUS_OPTIONS" => [
        'en' => ['0' => 'Inactive', '1' => 'Active'],
        'fr' => ['0' => 'Inactif', '1' => 'Actif'],
        'ar' => ['0' => 'غير نشط', '1' => 'نشط'],
    ],


    "PUBLISHING_STATE" => [
        "fr" => ["" => "--- spécifier l'état ---", 'published' => 'Publié', 'not_published' => 'Non publié'],
        "en" => ["" => "--- Specify State ---", 'published' => 'Published', 'not_published' => 'Not Published'],
        "ar" => ["" => "--- حدد الحالة ---", 'published' => 'تم النشر', 'not_published' => 'غير منشور'],
    ],
    "PROGRESS_STATE" => [
        "en" => [
            "" => "--- Specify Status ---",
            'completed' => 'Completed',
            'in_progress' => 'In Progress'
        ],
        "fr" => [
            "" => "--- Spécifier le statut ---",
            'completed' => 'Terminé',
            'in_progress' => 'En cours'
        ],
        'ar' => [
            "" => "--- تحديد الحالة ---",
            'completed' => 'مكتمل',
            'in_progress' => 'قيد التنفيذ'
        ]
    ],

    "MARITAL_STATE" => [
        "en" => ['' => '--- Specify ---', 'single' => 'Single', 'married' => 'Married', 'widowed' => 'Widowed', 'divorced' => 'Divorced'],
        "fr" => ['' => '--- spécifier ---', 'single' => 'Célibataire', 'married' => 'Marié(e)', 'widowed' => 'Veuf(ve)', 'divorced' => 'Divorcé(e)'],
        "ar" => ['' => '--- حدد ---', 'single' => 'أعزب', 'married' => 'متزوج', 'widowed' => 'أرمل', 'divorced' => 'مطلق'],
    ],

    "GENDER" => [
        "en" => ['' => '--- Specify ---', 'male' => 'Male', 'female' => 'Female', 'other' => "Other"],
        "fr" => ['' => '--- spécifier ---', 'male' => 'Homme', 'female' => 'Femme', "other" => 'Autre'],
        "ar" => ['' => '--- حدد ---', 'male' => 'ذكر', 'female' => 'أنثى', "other" => "آخر"],
    ],

    "MENU_TYPES" => [
        "en" => ['', 'external_links' => 'External Links', 'internal_links' => 'Internal Links'],
        "fr" => ['', 'external_links' => 'Liens externes', 'internal_links' => 'Liens internes'],
        "ar" => ['', 'external_links' => 'الروابط الخارجية', 'internal_links' => 'الروابط الداخلية'],
    ],

    "SERVICE_TYPE" => [
        "fr" => ['' => '--- Specify ---', 'administration' => 'Administration', 'health' => 'Santé'],
        'en' => ['' => '--- spécifier ---', 'administration' => 'Administration', 'health' => 'Health'],
        "ar" => ['' => '--- حدد ---', 'administration' => 'إدارة', 'health' => 'صحة'],
    ],

    "ESTABLISHMENT_TYPES" => [
        "en" => ["appointment_locations" => "Appointments Location", "clinic" => "Clinic"],
        "fr" => ["appointment_locations" => "Lieu de rendez-vous", "clinic" => "Clinique"],
        "ar" => ["appointment_locations" => "مكان المواعيد", "clinic" => "عيادة"],
    ],

    "APPOINTMENT_TYPES" => [
        "en" => ["initial" => "Initial Consultation", "follow-up" => "Follow-up Appointment"],
        "fr" => ["initial" => "Consultation Initiale", "follow-up" => "Rendez-vous de Suivi"],
        "ar" => ["initial" => "الاستشارة الأولية", "follow-up" => "موعد المتابعة"],
    ],
    "SLOTS_STATUS" => [
        "en" => [
            "available" => "Available",
            "booked" => "Booked",
            "blocked" => "Blocked",
        ],
        "fr" => [
            "available" => "Disponible",
            "booked" => "Réservé",
            "blocked" => "Bloqué",
        ],
        "ar" => [
            "available" => "متاح",
            "booked" => "محجوز",
            "blocked" => "محجوز",
        ],
    ],
    ///         aPP




    'ALGERIA_WILAYAS' => [
        'en' => [
            '' => '--- Specify ---',
            '01' => 'Adrar',
            '02' => 'Chlef',
            '03' => 'Laghouat',
            '04' => 'Oum El Bouaghi',
            '05' => 'Batna',
            '06' => 'Béjaïa',
            '07' => 'Biskra',
            '08' => 'Béchar',
            '09' => 'Blida',
            '10' => 'Bouira',
            '11' => 'Tamanrasset',
            '12' => 'Tébessa',
            '13' => 'Tlemcen',
            '14' => 'Tiaret',
            '15' => 'Tizi Ouzou',
            '16' => 'Algiers',
            '17' => 'Djelfa',
            '18' => 'Jijel',
            '19' => 'Sétif',
            '20' => 'Saïda',
            '21' => 'Skikda',
            '22' => 'Sidi Bel Abbès',
            '23' => 'Annaba',
            '24' => 'Guelma',
            '25' => 'Constantine',
            '26' => 'Médéa',
            '27' => 'Mostaganem',
            '28' => 'M’Sila',
            '29' => 'Mascara',
            '30' => 'Ouargla',
            '31' => 'Oran',
            '32' => 'El Bayadh',
            '33' => 'Illizi',
            '34' => 'Bordj Bou Arréridj',
            '35' => 'Boumerdès',
            '36' => 'El Tarf',
            '37' => 'Tindouf',
            '38' => 'Tissemsilt',
            '39' => 'El Oued',
            '40' => 'Khenchela',
            '41' => 'Souk Ahras',
            '42' => 'Tipaza',
            '43' => 'Mila',
            '44' => 'Aïn Defla',
            '45' => 'Naâma',
            '46' => 'Aïn Témouchent',
            '47' => 'Ghardaïa',
            '48' => 'Relizane',
            '49' => 'Timimoun',
            '50' => 'Bordj Badji Mokhtar',
            '51' => 'Ouled Djellal',
            '52' => 'Béni Abbès',
            '53' => 'In Salah',
            '54' => 'In Guezzam',
            '55' => 'Touggourt',
            '56' => 'Djanet',
            '57' => 'El M’Ghair',
            '58' => 'El Meniaa',
        ],

        'fr' => [
            '' => '--- spécifier ---',
            '01' => 'Adrar',
            '02' => 'Chlef',
            '03' => 'Laghouat',
            '04' => 'Oum El Bouaghi',
            '05' => 'Batna',
            '06' => 'Béjaïa',
            '07' => 'Biskra',
            '08' => 'Béchar',
            '09' => 'Blida',
            '10' => 'Bouira',
            '11' => 'Tamanrasset',
            '12' => 'Tébessa',
            '13' => 'Tlemcen',
            '14' => 'Tiaret',
            '15' => 'Tizi Ouzou',
            '16' => 'Alger',
            '17' => 'Djelfa',
            '18' => 'Jijel',
            '19' => 'Sétif',
            '20' => 'Saïda',
            '21' => 'Skikda',
            '22' => 'Sidi Bel Abbès',
            '23' => 'Annaba',
            '24' => 'Guelma',
            '25' => 'Constantine',
            '26' => 'Médéa',
            '27' => 'Mostaganem',
            '28' => 'M’Sila',
            '29' => 'Mascara',
            '30' => 'Ouargla',
            '31' => 'Oran',
            '32' => 'El Bayadh',
            '33' => 'Illizi',
            '34' => 'Bordj Bou Arréridj',
            '35' => 'Boumerdès',
            '36' => 'El Tarf',
            '37' => 'Tindouf',
            '38' => 'Tissemsilt',
            '39' => 'El Oued',
            '40' => 'Khenchela',
            '41' => 'Souk Ahras',
            '42' => 'Tipaza',
            '43' => 'Mila',
            '44' => 'Aïn Defla',
            '45' => 'Naâma',
            '46' => 'Aïn Témouchent',
            '47' => 'Ghardaïa',
            '48' => 'Relizane',
            '49' => 'Timimoun',
            '50' => 'Bordj Badji Mokhtar',
            '51' => 'Ouled Djellal',
            '52' => 'Béni Abbès',
            '53' => 'In Salah',
            '54' => 'In Guezzam',
            '55' => 'Touggourt',
            '56' => 'Djanet',
            '57' => 'El M’Ghair',
            '58' => 'El Meniaa',
        ],

        'ar' => [
            '' => '--- حدد ---',
            '01' => 'أدرار',
            '02' => 'الشلف',
            '03' => 'الأغواط',
            '04' => 'أم البواقي',
            '05' => 'باتنة',
            '06' => 'بجاية',
            '07' => 'بسكرة',
            '08' => 'بشار',
            '09' => 'البليدة',
            '10' => 'البويرة',
            '11' => 'تمنراست',
            '12' => 'تبسة',
            '13' => 'تلمسان',
            '14' => 'تيارت',
            '15' => 'تيزي وزو',
            '16' => 'الجزائر',
            '17' => 'الجلفة',
            '18' => 'جيجل',
            '19' => 'سطيف',
            '20' => 'سعيدة',
            '21' => 'سكيكدة',
            '22' => 'سيدي بلعباس',
            '23' => 'عنابة',
            '24' => 'قالمة',
            '25' => 'قسنطينة',
            '26' => 'المدية',
            '27' => 'مستغانم',
            '28' => 'المسيلة',
            '29' => 'معسكر',
            '30' => 'ورقلة',
            '31' => 'وهران',
            '32' => 'البيض',
            '33' => 'إليزي',
            '34' => 'برج بوعريريج',
            '35' => 'بومرداس',
            '36' => 'الطارف',
            '37' => 'تندوف',
            '38' => 'تيسمسيلت',
            '39' => 'الوادي',
            '40' => 'خنشلة',
            '41' => 'سوق أهراس',
            '42' => 'تيبازة',
            '43' => 'ميلة',
            '44' => 'عين الدفلى',
            '45' => 'النعامة',
            '46' => 'عين تموشنت',
            '47' => 'غرداية',
            '48' => 'غليزان',
            '49' => 'تيميمون',
            '50' => 'برج باجي مختار',
            '51' => 'أولاد جلال',
            '52' => 'بني عباس',
            '53' => 'عين صالح',
            '54' => 'عين قزام',
            '55' => 'تقرت',
            '56' => 'جانت',
            '57' => 'المغير',
            '58' => 'المنيعة',
        ],
    ],








    "ESTABLISHMENT_TYPES" => [
        "en" => [
            "appointment_locations" => "Appointments Location",
            "clinic" => "Clinic",
        ],
        "fr" => [
            "appointment_locations" => "Lieu de rendez-vous",
            "clinic" => "Clinique",
        ],
        "ar" => [
            "appointment_locations" => "مكان المواعيد",
            "clinic" => "عيادة",
        ],
    ],

'APPOINTMENT_DURATIONS' => [
    'en' => [
        '' => "-- Select Duration --",
        "15" => "15 min",
        "30" => "30 min",
        "45" => "45 min",
        "60" => "1 hour"
    ],
    'fr' => [
        '' => "-- Choisir la durée --",
        "15" => "15 min",
        "30" => "30 min",
        "45" => "45 min",
        "60" => "1 heure"
    ],
    "ar" => [
        '' => "-- اختر المدة --",
        "15" => "15 دقيقة",
        "30" => "30 دقيقة",
        "45" => "45 دقيقة",
        "60" => "ساعة واحدة"
    ]
],
];
