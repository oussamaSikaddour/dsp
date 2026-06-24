<?php

return [
    'site_parameters' => [
        'name' => 'إعدادات الموقع',
        'titles' => [
            'main' => 'إعدادات الموقع',
        ],
    ],

    "login" => [
        "name" => "تسجيل الدخول",
        'links' => [
            'register' => 'جديد في ' . config('app.name') . ' ؟ أنشئ حساباً الآن',
            'forgot_password' => 'هل نسيت كلمة المرور؟',
        ],
        "titles" => [
            'main' => 'تسجيل الدخول',
        ]
    ],

    'register' => [
        'name' => 'إنشاء حساب',
        'links' => [
            'login' => 'لديك حساب بالفعل؟',
        ],
        'titles' => [
            'main' => 'إنشاء حساب',
        ]
    ],

    "logout" => "تسجيل الخروج",

    'forgot_password' => [
        'name' => 'نسيت كلمة المرور',
        'titles' => [
            "main" => 'استعادة حسابك',
        ]
    ],

    "profile" => [
        'name' => "الملف الشخصي",
        "titles" => [
            "main" => "مرحباً بك في ملفك الشخصي"
        ]
    ],

    "change_password" => [
        'name' => "تغيير كلمة المرور",
        "titles" => [
            "main" => "تغيير كلمة المرور"
        ]
    ],

    "change_email" => [
        "name" => "تغيير البريد الإلكتروني",
        "titles" => [
            "main" => "تغيير البريد الإلكتروني"
        ]
    ],

    "dashboard" => [
        'name' => "لوحة التحكم",
        "titles" => [
            "main" => "مرحباً بك في لوحة التحكم :name"
        ],
        'messages' => [
            'simple_user' => 'مرحباً :name في منصة تلمسان الصحية - يمكنك حجز المواعيد لنفسك أو لأفراد عائلتك',
            'multi_role_user' => 'مرحباً :name في منصة تلمسان الصحية - حساب متعدد الأدوار، يمكنك حجز المواعيد لنفسك أو لأفراد عائلتك ولديك إمكانية الوصول إلى ميزات متعددة',
        ],
    ],

    "super_admin_space" => [
        'name' => "لوحة تحكم المدير العام",
        "titles" => [
            "main" => "مرحباً بك في لوحة تحكم المدير العام"
        ]
    ],


    "manage_users" => [
        'name' => "إدارة المستخدمين",
        "titles" => [
            "main" => "إدارة المستخدمين"
        ]
    ],

    "general_infos" => [
        "name" => "إدارة المعلومات العامة",
        "titles" => [
            "main" => "إدارة المعلومات العامة للتطبيق"
        ],
    ],

    "manage_hero" => [
        "name" => "إدارة قسم الواجهة",
        "titles" => [
            "main" => "إدارة قسم الواجهة"
        ],
    ],

    "manage_about_us" => [
        "name" => "إدارة قسم من نحن",
        "titles" => [
            "main" => "إدارة قسم من نحن"
        ],
    ],

    'messages' => [
        'name' => "رسائل الزوار",
        'titles' => [
            'main' => "صندوق رسائل الزوار",
        ],
    ],


    'sliders' => [
        'name' => 'إدارة العارضات',
        'titles' => [
            'main' => 'إدارة العارضات',
        ],
    ],

    'slider' => [
        'name' => 'إدارة الشرائح',
        'titles' => [
            'main' => 'إدارة شرائح :name',
        ],
    ],

    'trends' => [
        'name' => 'إدارة الاتجاهات',
        'titles' => [
            'main' => 'إدارة الاتجاهات',
        ],
    ],

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// App
    "wilayates" => [
        'name' => "الولايات",
        "titles" => [
            "main" => "لوحة تحكم الولايات"
        ]
    ],
    "wilaya" => [
        'name' => ":name",
        "titles" => [
            "main" => "دوائر :name"
        ]
    ],
    "occupation_fields" => [
        'name' => "المجالات المهنية",
        "titles" => [
            "main" => "إدارة المجالات"
        ]
    ],


    'landing_page' => [
        'name' => 'الصفحة الرئيسية',

        'welcome' => [
            'country_name' => 'الجمهورية الجزائرية الديمقراطية الشعبية',
            'ministry_name' => 'وزارة الصحة',

            'title' => 'مرحبًا بكم في البوابة الصحة لولاية تلمسان',

            'description' => 'منصة رقمية تمكّن المواطنين من الوصول إلى الخدمات الصحية والمواعيد الطبية وسجلاتهم الطبية الشخصية بطريقة آمنة ومريحة.',

            'login_text' => 'لدي حساب بالفعل',
            'login_button' => 'تسجيل الدخول',

            'register_text' => 'ليس لديك حساب؟',
            'register_button' => 'إنشاء حساب',
        ],

    ],

    'establishments' => [
        'name' => 'المؤسسات',
        'titles' => [
            'main' => 'لوحة تحكم المؤسسات',
        ],
    ],

    'establishment' => [
        'name' => ':name',
        'titles' => [
            'main' => ':name',
        ],
    ],
    "manage_establishment_users" => [
        'name' => "مستخدمي المؤسسة",
        "titles" => [
            "main" => 'إدارة مستخدمي :name'
        ]
    ],
    "manage_establishment_services" => [
        'name' => "أقسام المؤسسة",
        "titles" => [
            "main" => 'أقسام :name'
        ]
    ],

    "manage_service" => [
        'name' => "القسم",
        "titles" => [
            "main" => 'القسم :name'
        ]
    ],
    "manage_schedules" => [
        'name' => "جداول القسم",
        "titles" => [
            "main" => "جداول :name"
        ]
    ],
    "manage_schedule" => [
        'name' => "جدول :name",
        "titles" => [
            "main" => "إدارة جدول :service - :name"
        ]
    ],
    "medical_file" => [
        'name' => "الملف الطبي",
        "titles" => [
            "main" => 'إدارة الملف الطبي لـ :name برمز : :code'
        ]
    ],
    "medical_files" => [
        'name' => "الملفات الطبية",
        "titles" => [
            "main" => "السجلات الطبية للمرضى - تاريخ الاستشارات"
        ]
    ],
    "patient_visits" => [
        'name' => "زيارات المرضى",
        "titles" => [
            "main" => ":name :code - تاريخ الزيارات الطبية"
        ]
    ],

    "manage_appointments_location_admins" => [
        'name' => "إدارة مواقع المواعيد",
        "titles" => [
            "main" => "لوحة تحكم مواقع المواعيد"
        ]
    ],
    "patient" => [
        'name' => "إدارة المواعيد",
        "titles" => [
            "main" => "إدارة مواعيد :name"
        ]
    ],

    'services' => [
        'name' => 'إدارة الأقسام',
        'titles' => [
            'main' => 'إدارة الأقسام',
        ],
    ],
    "appointments" => [
        'name' => "إدارة قوائم المواعيد",
        "titles" => [
            "main" => "إدارة قائمة مواعيد :name"
        ]
    ],
    "manage_patients" => [
        "name" => "إدارة المرضى",
        "titles" => [
            "main" => "إدارة المرضى وحجز مواعيد جديدة"
        ]
    ],

    "doctor_appointments" => [
        "name" => "المواعيد",
        "titles" => [
            "main" => "المواعيد – قسم :name"
        ]
    ],
    "medical_exams" => [
        "name" => ":code – الفحوصات",
        "titles" => [
            "main" => "الفحوصات الطبية لـ :name (:code)"
        ]
    ],
    "service_patients" => [
    "name" => "مرضى القسم",
    "titles" => [
        "main" => ":name – المرضى"
    ]
],
];
