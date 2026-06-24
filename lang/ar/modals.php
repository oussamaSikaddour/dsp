<?php

return [

    'user' => [
        'actions' => [
            'add' => "إنشاء مستخدم",
            'update' => "تعديل المستخدم: :name",
            'manage' => [
                'roles' => 'إدارة الأدوار: :name',
            ],
        ],
    ],

    "message" => [
        "actions" => [
            "reply" => "إرسال رد"
        ]
    ],
    'slider' => [
        'actions' => [
            'add' => 'إضافة عرض تقديمي جديد لـ :name',
            'update' => 'تحديث العرض التقديمي :name',
        ],
    ],
    'slide' => [
        'actions' => [
            'add' => 'إضافة شريحة جديدة',
            'update' => 'تحديث الشريحة المحددة',
        ],
    ],
    'article' => [
        'actions' => [
            'add' => 'إضافة مقال جديد',
            'update' => 'تحديث المقال المحدد',
        ],
    ],
    'trend' => [
        'actions' => [
            'add' => 'إضافة اتجاه جديد',
            'update' => 'تحديث الاتجاه المحدد',
        ],
    ],
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////           App


    'person' => [
        'actions' => [
            'add' => "إضافة موظفين",
            'update' => "تعديل الموظف : :name",
            'manage' => [
                'occupations' => 'إدارة المهن : :name',
                'banking_information' => 'إدارة المعلومات البنكية : :name',
                'account' => 'إدارة الحساب : :name',
            ],
        ],
    ],

    'field' => [
        'actions' => [
            'add' => 'إنشاء مجال مهني جديد',
            'update' => 'تحديث المجال : :acronym',
            'manage' => [
                'grades' => 'إدارة مستويات الدرجات',
                'specialties' => 'إدارة التخصصات',
            ],
        ],
    ],

    'wilaya' => [
        'actions' => [
            'add' => 'إضافة ولاية جديدة',
            'update' => 'تحديث الولاية : :name',
            'manage' => [
                'view' => 'عرض تفاصيل الولاية',
            ],
        ],
    ],

    'daira' => [
        'actions' => [
            'add' => 'إضافة دائرة جديدة',
            'update' => 'تحديث الدائرة : :name',
            'manage' => "إدارة بلديات الدائرة :name",
        ],
    ],

    'service' => [
        'actions' => [
            'add' => 'إضافة قسم جديد',
            'update' => 'تحديث القسم المحدد',
            "manage_coordinators" => "إدارة منسقي :name",
        ],
    ],

    'establishment' => [
        'actions' => [
            'add' => 'إنشاء مؤسسة جديدة',
            'update' => 'تحديث المؤسسة : :acronym',
        ],
    ],
    'coordinators' => [
        'actions' => [
            'manage' => 'إدارة المنسقين',
        ],
    ],

    'doctors' => [
        'actions' => [
            'manage' => 'إدارة الأطباء',
        ],
    ],

    'medical_secretaries' => [
        'actions' => [
            'manage' => 'إدارة السكرتيرات الطبيات',
        ],
    ],
    'appointments_locations_agents' => [
        'actions' => [
            'manage' => 'إدارة وكلاء مواقع المواعيد',
        ],
    ],
    'schedule' => [
        'actions' => [
            'add' => 'إنشاء جدول جديد',
            'update' => 'تحديث الجدول :name',
            "manage" => 'إدارة تواريخ الجدول ":name"',
        ],
    ],
    'schedule_day' => [
        'actions' => [
            'add' => 'إضافة تاريخ إلى الجدول',
            'update' => "تحديث جدول التاريخ :date",
            'view' => "عرض فترات جدول :date",
        ],
    ],
    'patient' => [
        "actions" => [
            "add" => [
                "relative" => "إضافة نفسك أو أحد أفراد العائلة",
                "patient" => "تسجيل مريض جديد",
            ],
            "update" => [
                "relative" => "تحديث بيانات :name",
                "patient" => "تحديث المريض :code – :name"
            ]
        ]
    ],
    "appointment" => [
        "actions" => [
            "book" => "حجز موعد",
            "follow-up" => "حجز متابعة للمريض :code - :name",
            "view" => "عرض خطاب التحويل بتاريخ :date"
        ]
    ],

"medical_exam" => [
    "actions" => [
        "add" => [
            "simple" => "فحص جديد",
            "detailed" => "فحص – :code :name"
        ],
        'update' => "تعديل – :code :name",
        "manage" => [
            "images" => "الصور – :name",
            "files" => "المستندات – :name",
        ]
    ]
],
];
