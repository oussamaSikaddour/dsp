<?php

return [

    'user' => [
        'actions' => [
            'add' => "Créer un utilisateur",
            'update' => "Modifier l'utilisateur : :name",
            'manage' => [
                'roles' => 'Gérer les rôles : :name',
            ],
        ],
    ],

    "message" => [
        "actions" => [
            "reply" => "Envoyer une réponse"
        ]
    ],
    'slider' => [
        'actions' => [
            'add' => 'Ajouter un nouveau diaporama pour :name',
            'update' => 'Mettre à jour le diaporama :name',
        ],
    ],
    'slide' => [
        'actions' => [
            'add' => 'Ajouter une nouvelle diapositive',
            'update' => 'Mettre à jour la diapositive sélectionnée',
        ],
    ],

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    'person' => [
        'actions' => [
            'add' => "Ajouter du personnel",
            'update' => "Modifier le personnel : :name",
            'manage' => [
                'occupations' => 'Gérer les occupations : :name',
                'banking_information' => 'Gérer les informations bancaires : :name',
                'account' => 'Gérer le compte : :name',
            ],
        ],
    ],

    'field' => [
        'actions' => [
            'add' => 'Créer un nouveau domaine professionnel',
            'update' => 'Mettre à jour le domaine : :acronym',
            'manage' => [
                'grades' => 'Gérer les niveaux de grade',
                'specialties' => 'Gérer les spécialisations',
            ],
        ],
    ],

    'wilaya' => [
        'actions' => [
            'add' => 'Ajouter une nouvelle wilaya',
            'update' => 'Mettre à jour la wilaya : :name',
            'manage' => [
                'view' => 'Voir les détails de la wilaya',
            ],
        ],
    ],

    'daira' => [
        'actions' => [
            'add' => 'Ajouter une nouvelle daïra',
            'update' => 'Mettre à jour la daïra : :name',
            'manage' => "Gérer les communes de la daïra :name",
        ],
    ],

    'service' => [
        'actions' => [
            'add' => 'Ajouter un nouveau département',
            'update' => 'Mettre à jour le département sélectionné',
            "manage_coordinators" => "Gérer les coordinateurs de :name",
        ],
    ],

    'establishment' => [
        'actions' => [
            'add' => 'Créer un nouvel établissement',
            'update' => 'Mettre à jour l\'établissement : :acronym',
        ],
    ],
    'coordinators' => [
        'actions' => [
            'manage' => 'Gérer les coordinateurs',
        ],
    ],

    'doctors' => [
        'actions' => [
            'manage' => 'Gérer les médecins',
        ],
    ],

    'medical_secretaries' => [
        'actions' => [
            'manage' => 'Gérer les secrétaires médicales',
        ],
    ],

    'appointments_locations_agents' => [
        'actions' => [
            'manage' => 'Gérer les agents des lieux de rendez-vous',
        ],
    ],
    'schedule' => [
        'actions' => [
            'add' => 'Créer un nouveau planning',
            'update' => 'Mettre à jour le planning :name',
            "manage" => 'Gérer les dates du planning ":name"',
        ],
    ],

    'schedule_day' => [
        'actions' => [
            'add' => 'Ajouter une date au planning',
            'update' => "Mettre à jour le planning de la date :date",
            'view' => "Voir les créneaux du planning du :date",
        ],
    ],
    'patient' => [
        "actions" => [
            "add" => [
                "relative" => "Ajouter vous-même ou un membre de la famille",
                "patient" => "Enregistrer un nouveau patient",
            ],
            "update" => [
                "relative" => "Modifier les informations de :name",
                "patient" => "Modifier le patient :code – :name"
            ]
        ]
    ],

    "appointment" => [
        "actions" => [
            "book" => "Prendre un rendez-vous",
            "follow-up" => "Planifier un suivi pour le patient :code - :name",
            "view" => "Voir la lettre d'orientation du :date"
        ]
    ],
    "medical_exam" => [
        "actions" => [
            "add" => [
                "simple" => "Nouvel examen médical",
                "detailed" => "Nouvel examen pour le patient :code – :name"
            ],
            'update' => "Modifier l'examen pour :code – :name",
            "manage" => [
                "images" => "Images de l'examen – :name",
                "files" => "Documents de l'examen – :name",
            ]
        ]
    ],

];
