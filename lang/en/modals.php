<?php
return [

    'user' => [
        'actions' => [
            'add' => "Create User",
            'update' => "Edit User: :name",
            'manage' => [
                'roles' => 'Manage Roles: :name',
            ],
        ],
    ],

    "message" => [
        "actions" => [
            "reply" => "Send A reply"
        ]
    ],
    'slider' => [
        'actions' => [
            'add' => 'Add New Slider for :name',
            'update' => 'Update The Slider :name ',
        ],
    ],
    'slide' => [
        'actions' => [
            'add' => 'Add New Slide',
            'update' => 'Update The Selected Slide',
        ],
    ],

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    'person' => [
        'actions' => [
            'add' => "Add Personnel",
            'update' => "Edit Personnel: :name",
            'manage' => [
                'occupations' => 'Manage Occupations: :name',
                'banking_information' => 'Manage Banking: :name',
                'account' => 'Manage Account: :name',
            ],
        ],
    ],

    'field' => [
        'actions' => [
            'add' => 'Create New Professional Field',
            'update' => 'Update Field: :acronym',
            'manage' => [
                'grades' => 'Manage Grade Levels',
                'specialties' => 'Manage Specializations',
            ],
        ],
    ],
    'wilaya' => [
        'actions' => [
            'add' => 'Add New State',
            'update' => 'Update State: :name',
            'manage' => [
                'view' => 'View State Details',
            ],
        ],
    ],
    'daira' => [
        'actions' => [
            'add' => 'Add New District',
            'update' => 'Update District: :name',
            'manage' => "Manage District :name Communes"
        ],
    ],

    'service' => [
        'actions' => [
            'add' => 'Add New Service',
            'update' => 'Update The Selected Service',
            "manage_coordinators" => "Manage :name Coordinators",
        ],
    ],


    'establishment' => [
        'actions' => [
            'add' => 'Create New Establishment',
            'update' => 'Update Establishment: :acronym',
        ],
    ],
    'coordinators' => [
        'actions' => [
            'manage' => 'Manage coordinators',
        ],
    ],

    'doctors' => [
        'actions' => [
            'manage' => 'Manage doctors',
        ],
    ],

    'medical_secretaries' => [
        'actions' => [
            'manage' => 'Manage medical secretaries',
        ],
    ],
    'appointments_locations_agents' => [
        'actions' => [
            'manage' => 'Manage Appointments Locations agents',
        ],
    ],
    'schedule' => [
        'actions' => [
            'add' => 'Create New Schedule',
            'update' => 'Update the Schedule :name',
            "manage" => 'Manage The Planning ":name" Dates',
        ],
    ],
    'schedule_day' => [
        'actions' => [
            'add' => 'add a date to the Schedule',
            'update' => "Update schedule the date :date",
            'view' => "View schedule slots of :date",
        ],
    ],
'patient' => [
    "actions" => [
        "add" => [
            "relative" => "Add Yourself or a Family Member",
            "patient" => "Register a New Patient",
        ],
        "update" => [
            "relative" => "Update :name's Details",
            "patient" => "Update Patient :code – :name"
        ]
    ]
],
"appointment" => [
    "actions" => [
        "book" => "Book an Appointment",
        "follow-up" => "Book a Follow-up for the patient :code - :name",
        "view" => "View Referral Letter for :date"
    ]
],
"medical_exam" => [
    "actions" => [
        "add" => [
            "simple" => "New Medical Exam",
            "detailed" => "New Exam for Patient :code – :name"
        ],
        'update' => "Edit Exam for :code – :name",
        "manage" => [
            "images" => "Exam Images – :name",
            "files" => "Exam Documents – :name",
        ]
    ]
],

];
