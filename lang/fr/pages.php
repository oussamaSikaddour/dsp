<?php

return [

    'site_parameters' => [
        'name' => 'Paramètres du site',
        'titles' => [
            'main' => 'Paramètres du site',
        ],
    ],
    "login" => [
        "name" => "Connexion",

        'links' => [
            'register' => 'Nouveau sur ' . config('app.name') . ' ? Inscrivez-vous maintenant',
            'forgot_password' => 'Mot de passe oublié?',
        ],

        "titles" => [
            'main' => 'Se connecter',
        ]
    ],
    'register' => [
        'name' => 'Inscription',
        'links' => [
            'login' => 'Vous avez déjà un compte?',
        ],
        'titles' => [
            'main' => 'S\'inscrire',
        ]
    ],
    "logout" => "Se déconnecter",
    'forgot_password' => [
        'name' => 'Mot de passe oublié',
        'titles' => [
            "main" => 'Récupérer votre compte',
        ]
    ],
    "profile" => [
        'name' => "Profil",
        "titles" => [
            "main" => "Bienvenue dans votre profil"
        ]
    ],

    "change_password" => [
        'name' => "Changer le mot de passe",
        "titles" => [
            "main" => "Changer votre mot de passe"
        ]
    ],
    "change_email" => [
        "name" => "Changer l'email",
        "titles" => [
            "main" => "Changer votre email"
        ]
    ],

    "dashboard" => [
        'name' => "Tableau de bord",
        "titles" => [
            "main" => "Bienvenue sur le tableau de bord :name"
        ],
        'messages' => [
            'simple_user' => 'Bienvenue :name sur la Plateforme Santé de Tlemcen - Vous pouvez prendre des rendez-vous pour vous-même ou pour vos proches',
            'multi_role_user' => 'Bienvenue :name sur la Plateforme Santé de Tlemcen - Compte multi-rôles, vous pouvez prendre des rendez-vous pour vous-même ou pour vos proches et vous avez accès à plusieurs fonctionnalités',
        ],
    ],
    "super_admin_space" => [
        'name' => "Tableau de bord Super Admin",
        "titles" => [
            "main" => "Bienvenue sur le tableau de bord Super Admin"
        ]
    ],


    "manage_users" => [
        'name' => "Gérer les utilisateurs",
        "titles" => [
            "main" => "Gérer les utilisateurs"
        ]
    ],

    "general_infos" => [
        "name" => "Gérer les informations générales",
        "titles" => [
            "main" => "Gérer les informations générales de l'application"
        ],
    ],
    "manage_hero" => [
        "name" => "Gérer la section Hero",
        "titles" => [
            "main" => "Gérer la section Hero"
        ],
    ],
    "manage_about_us" => [
        "name" => "Gérer la section À propos",
        "titles" => [
            "main" => "Gérer la section À propos"
        ],
    ],
    'messages' => [
        'name' => 'Messages des visiteurs',
        'titles' => [
            'main' => 'Boîte de réception des messages des visiteurs',
        ],
    ],

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// App

    "wilayates" => [
        'name' => "Wilayas",
        "titles" => [
            "main" => "Administration des wilayas"
        ]
    ],
    "wilaya" => [
        'name' => ":name",
        "titles" => [
            "main" => "Daïras de :name"
        ]
    ],
    "occupation_fields" => [
        'name' => "Domaines pro.",
        "titles" => [
            "main" => "Gestion des domaines"
        ]
    ],




    'landing_page' => [
        'name' => 'Page d\'accueil',

        'welcome' => [
            'country_name' => 'République Algérienne Démocratique et Populaire',
            'ministry_name' => 'Ministère de la Santé',

            'title' => 'Bienvenue sur le Portail Santé de Tlemcen',

            'description' => 'Une plateforme numérique qui permet aux citoyens d\'accéder aux services de santé, aux rendez-vous médicaux et à leurs dossiers médicaux personnels de manière sécurisée et pratique.',

            'login_text' => 'J\'ai déjà un compte',
            'login_button' => 'Se connecter',

            'register_text' => 'Vous n\'avez pas de compte ?',
            'register_button' => 'S\'inscrire',
        ],

    ],

    'establishments' => [
        'name' => 'Établissements',
        'titles' => [
            'main' => 'Administration des établissements',
        ],
    ],

    'establishment' => [
        'name' => ':name',
        'titles' => [
            'main' => ':name',
        ],
    ],

    "manage_establishment_users" => [
        'name' => "Utilisateurs de l'établissement",
        "titles" => [
            "main" => 'Gérer les utilisateurs de :name'
        ]
    ],
    "manage_establishment_services" => [
        'name' => "Services de l'établissement",
        "titles" => [
            "main" => 'Gérer les services de :name'
        ]
    ],
    "manage_service" => [
        'name' => "Gérer le département",
        "titles" => [
            "main" => 'Gérer le département :name'
        ]
    ],

    "manage_schedules" => [
        'name' => "Gérer les plannings du département",
        "titles" => [
            "main" => "Gérer les plannings du département :name"
        ]
    ],
    "manage_schedule" => [
        'name' => "Planning :name",
        "titles" => [
            "main" => "Gérer le planning :service - :name"
        ]
    ],

    "medical_file" => [
        'name' => "Dossier médical",
        "titles" => [
            "main" => 'Gérer le dossier médical de :name code : :code'
        ]
    ],
    "medical_files" => [
        'name' => "Dossiers médicaux",
        "titles" => [
            "main" => "Dossiers médicaux des patients - Historique des consultations"
        ]
    ],
    "patient_visits" => [
        'name' => "Visites des patients",
        "titles" => [
            "main" => ":name :code - Historique des visites médicales"
        ]
    ],

    "manage_appointments_location_admins" => [
        'name' => "Gérer les lieux de rendez-vous",
        "titles" => [
            "main" => "Tableau de bord des lieux de rendez-vous"
        ]
    ],

    "patient" => [
        'name' => "Gérer les rendez-vous",
        "titles" => [
            "main" => "Gérer les rendez-vous de :name"
        ]
    ],
    'services' => [
        'name' => 'Gérer les départements',
        'titles' => [
            'main' => 'Gérer les départements',
        ],
    ],
"appointments" => [
    'name' => "Gérer les listes de rendez-vous",
    "titles" => [
        "main" => "Gérer la liste des rendez-vous de :name"
    ]
],
"manage_patients" => [
    "name" => "Gestion des patients",
    "titles" => [
        "main" => "Gérer les patients et planifier de nouveaux rendez-vous"
    ]
],

"doctor_appointments" => [
    "name" => "Rendez-vous",
    "titles" => [
        "main" => "Rendez-vous –  :name"
    ]
],
"medical_exams" => [
    "name" => ":code – Examens",
    "titles" => [
        "main" => "Examens médicaux pour :name (:code)"
    ]
],
"service_patients" => [
    "name" => "Patients du service",
    "titles" => [
        "main" => ":name – Patients"
    ]
],
];
