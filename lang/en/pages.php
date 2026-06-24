<?php

return [
    'site_parameters' => [
        'name' => 'Site Settings',
        'titles' => [
            'main' => 'Site Settings',
        ],
    ],
    "login" => [
        "name" => "Login",

        'links' => [
            'register' => 'New to ' . config('app.name') . ' ? Register Now',
            'forgot_password' => 'Forgot Your Password?',
        ],

        "titles" => [
            'main' => 'Sign In',
        ]
    ],
    'register' => [
        'name' => 'Register',
        'links' => [
            'login' => 'Already have an account?',
        ],
        'titles' => [
            'main' => 'Sign Up',
        ]
    ],
    "logout" => "Log Out",
    'forgot_password' => [
        'name' => 'Forgot Password',
        'titles' => [
            "main" => 'Recover Your Account',
        ]
    ],
    "profile" => [
        'name' => "Profile",
        "titles" => [
            "main" => "Welcome to Your Profile"
        ]
    ],

    "change_password" => [
        'name' => "Change Password",
        "titles" => [
            "main" => "Change Your Password"
        ]
    ],
    "change_email" => [
        "name" => "Change Email",
        "titles" => [
            "main" => "Change Your Email"
        ]
    ],

    "dashboard" => [
        'name' => "Dashboard",
        "titles" => [
            "main" => "Welcome to the Dashboard :name"
        ],
        'messages' => [
            'simple_user' => 'Welcome :name to the Tlemcen Health Platform - You can book appointments for yourself or your family members',
            'multi_role_user' => 'Welcome :name to Tlemcen Health Platform - Multi-role account, You can book appointments for yourself or your family members and you have access to multiple features',
        ],
    ],
    "super_admin_space" => [
        'name' => "Super Admin Dashboard",
        "titles" => [
            "main" => "Welcome to the Super Admin Dashboard"
        ]
    ],

    "manage_users" => [
        'name' => "Manage Users",
        "titles" => [
            "main" => "Manage Users"
        ]
    ],





    "general_infos" => [
        "name" => "Manage General Information",
        "titles" => [
            "main" => "Manage App General Information"
        ],
    ],
    "manage_hero" => [
        "name" => "Manage Hero Section",
        "titles" => [
            "main" => "Manage Hero Section"
        ],
    ],
    "manage_about_us" => [
        "name" => "Manage About Us Section",
        "titles" => [
            "main" => "Manage About Us Section"
        ],
    ],

    'messages' => [
        'name' => "Visitors' Messages",
        'titles' => [
            'main' => "Visitors' Messages Inbox",
        ],
    ],

    'sliders' => [
        'name' => 'Manage Sliders',
        'titles' => [
            'main' => 'Manage Sliders',
        ],
    ],
    'slider' => [
        'name' => 'Manage Slides',
        'titles' => [
            'main' => 'Manage :name Slides',
        ],
    ],

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// App

    "wilayates" => [
        'name' => "States",
        "titles" => [
            "main" => "State Management"
        ]
    ],
    "wilaya" => [
        'name' => ":name",
        "titles" => [
            "main" => "manage The States :name  districts"
        ]
    ],
    "occupation_fields" => [
        'name' => "Professional Fields",
        "titles" => [
            "main" => "Manage Professional Fields"
        ]
    ],




    'landing_page' => [
        'name' => 'Landing Page',

        'welcome' => [
            'country_name' => 'People\'s Democratic Republic of Algeria',
            'ministry_name' => 'Ministry of Health',

            'title' => 'Welcome to Tlemcen Health Portal',

            'description' => 'A digital platform that enables citizens to access healthcare services, medical appointments, and personal medical records securely and conveniently.',

            'login_text' => 'I already have an account',
            'login_button' => 'Sign In',

            'register_text' => 'Don\'t have an account?',
            'register_button' => 'Register Now',
        ],


        'establishments' => [
            'name' => 'Établissements',
            'titles' => [
                'main' => 'Gestion des établissements',
            ],
        ],

        'establishment' => [
            'name' => ':name',
            'titles' => [
                'main' => 'Gérer :name',
            ],
        ],
    ],

    "manage_establishment_users" => [
        'name' => "Establishment Users",
        "titles" => [
            "main" => 'Manage The :name Users'
        ]
    ],
    "manage_establishment_services" => [
        'name' => "Establishment Services",
        "titles" => [
            "main" => 'Manage The :name Services'
        ]
    ],
    "manage_service" => [
        'name' => "Manage Service",
        "titles" => [
            "main" => 'Manage The service :name'
        ]
    ],
    "manage_schedules" => [
        'name' => "Manage Service's Schedules",
        "titles" => [
            "main" => "Manage The Service :name's Schedules"
        ]
    ],
    "manage_schedule" => [
        'name' => "Schedule :name",
        "titles" => [
            "main" => "Manage :service Schedule - :name"
        ]
    ],
    "medical_file" => [
        'name' => "Medical File",
        "titles" => [
            "main" => 'Manage The Medical File of :name code : :code'
        ]
    ],
    "medical_files" => [
        'name' => "Medical Files",
        "titles" => [
            "main" => "Patient Medical Records - Consultation History"
        ]
    ],
    "patient_visits" => [
        'name' => "Patient Visits",
        "titles" => [
            "main" => ":name :code - Medical Visits History"
        ]
    ],


    "manage_appointments_location_admins" => [
        'name' => "Manage Appointments Locations",
        "titles" => [
            "main" => "Appointments Locations Dashboard"
        ]
    ],
    "patient" => [
        'name' => "Manage Appointments",
        "titles" => [
            "main" => "Manage :name's appointments"
        ]
    ],


    'services' => [
        'name' => 'Manage Services',
        'titles' => [
            'main' => 'Manage Services', // Added apostrophe for possessive
        ],
    ],
"appointments" => [
    'name' => "Manage Appointments Lists",
    "titles" => [
        "main" => "manage :name's appointments list"
    ]
],

"manage_patients" => [
    "name" => "Patient Management",
    "titles" => [
        "main" => "Manage Patients & Schedule New Appointments"
    ]
],
"manage_patients" => [
    "name" => "Patient Management",
    "titles" => [
        "main" => "Manage Patients & Schedule New Appointments"
    ]
],
"doctor_appointments" => [
    "name" => "Appointments",
    "titles" => [
        "main" => ":name  – Appointments"
    ]
],
"service_patients" => [
    "name" => "Service patients",
    "titles" => [
        "main" => ":name  – Patients"
    ]
],
"medical_exams" => [
    "name" => ":code – Exams",
    "titles" => [
        "main" => "Medical Exams for :name (:code)"
    ]
],

];
