<?php

return [

    /*
    |--------------------------------------------------------------------------
    | TITRES (LIBELLÉS DES ACTIONS DANS L'INTERFACE)
    |--------------------------------------------------------------------------
    */

    'title' => [

        /*
        |--------------------------------------------------------------------------
        | ACTIONS DE SUPPRESSION
        |--------------------------------------------------------------------------
        */
        'delete' => [
"image" => "Supprimer l'image",
"file" => "Supprimer le fichier",
            // Générique
            'user' => 'Supprimer l\'utilisateur',
            'message' => 'Supprimer le message',
            'slider' => 'Supprimer le slider',
            'slide' => 'Supprimer la diapositive',

            // Structure de l'application
            'establishment' => 'Supprimer l\'établissement',
            'wilaya' => 'Supprimer la wilaya',
            'daira' => 'Supprimer la daïra',
            'commune' => 'Supprimer la commune',

            // Structure professionnelle
            'field' => 'Supprimer le domaine professionnel',
            'field_grade' => 'Supprimer le niveau de grade',
            'field_specialty' => 'Supprimer la spécialisation professionnelle',
            'service' => 'Supprimer le département',

            // Planification
            'schedule' => 'Supprimer le planning',
            'schedule_day' => 'Supprimer le jour de planning',
            'medical_exam' => 'Supprimer l\'examen médical du patient',
        ],

        /*
        |--------------------------------------------------------------------------
        | ACTIONS DE PLANIFICATION
        |--------------------------------------------------------------------------
        */
        'schedule' => [
            'publish' => 'Publier le planning',
            'generate_days' => 'Générer les jours du planning',

            'generate_slots' => [
                "one" => "Générer les créneaux",
                "all" => "Générer les créneaux pour tous les jours"
            ]
        ],

        "slot" => [
            "block" => "Bloquer le créneau",
            "unblock" => "Débloquer le créneau"
        ],
        /*
        |--------------------------------------------------------------------------
        | ACTIONS DES RÔLES / PERMISSIONS
        |--------------------------------------------------------------------------
        */
        'roles' => [
            'detach' => [
                'coordinator' => 'Dissocier le coordinateur',
                'appointments_location_agent' => 'Dissocier l\'agent du lieu de rendez-vous',
                'doctor' => 'Dissocier le médecin',
                'medical_secretary' => 'Dissocier la secrétaire médicale',
            ],
        ],

        /*
        |--------------------------------------------------------------------------
        | ACTIONS DES RENDEZ-VOUS
        |--------------------------------------------------------------------------
        */
        'appointment' => [

            'confirm' => 'Confirmer le rendez-vous',
            'cancel' => 'Annuler le rendez-vous',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CONFIRMATIONS
    |--------------------------------------------------------------------------
    */

    'confirmation' => [

        /*
        |--------------------------------------------------------------------------
        | CONFIRMATIONS DE SUPPRESSION
        |--------------------------------------------------------------------------
        */
        'delete' => [
            "file" => 'Êtes-vous sûr de vouloir supprimer définitivement le fichier ":attribute" ?',
            "image" => 'Êtes-vous sûr de vouloir supprimer définitivement l\'image ":attribute" ?',
            // Générique
            'user' => 'Êtes-vous sûr de vouloir supprimer définitivement l\'utilisateur ":attribute" ?',
            'message' => 'Êtes-vous sûr de vouloir supprimer définitivement le message de ":attribute" ?',
            'slider' => 'Êtes-vous sûr de vouloir supprimer définitivement le slider ":attribute" ?',
            'slide' => 'Êtes-vous sûr de vouloir supprimer définitivement la diapositive ":attribute" ?',

            // Structure de l'application
            'establishment' => 'Êtes-vous sûr de vouloir supprimer définitivement l\'établissement ":attribute" ?',
            'wilaya' => 'Êtes-vous sûr de vouloir supprimer définitivement la wilaya (code : :attribute) ?',
            'daira' => 'Êtes-vous sûr de vouloir supprimer définitivement la daïra (code : :attribute) ?',
            'commune' => 'Êtes-vous sûr de vouloir supprimer définitivement la commune (code : :attribute) ?',

            // Structure professionnelle
            'field' => 'Êtes-vous sûr de vouloir supprimer définitivement le domaine professionnel ":attribute" ?',
            'field_grade' => 'Êtes-vous sûr de vouloir supprimer définitivement le niveau de grade ":attribute" ?',
            'field_specialty' => 'Êtes-vous sûr de vouloir supprimer définitivement la spécialisation professionnelle ":attribute" ?',
            'service' => 'Êtes-vous sûr de vouloir supprimer définitivement le département ":attribute" ?',

            // Planification
            'schedule' => 'Êtes-vous sûr de vouloir supprimer définitivement le planning ":attribute" ?',
            'schedule_day' => 'Êtes-vous sûr de vouloir supprimer définitivement le jour de planning daté du ":attribute" ?',
            'medical_exam' => 'Êtes-vous sûr de vouloir supprimer définitivement l\'examen médical du patient créé le ":attribute" ?',
        ],

        /*
        |--------------------------------------------------------------------------
        | CONFIRMATIONS DE PLANIFICATION
        |--------------------------------------------------------------------------
        */
        'schedule' => [

            'publish' =>
            'Êtes-vous certain de vouloir publier le planning ":attribute" ? Après publication, seules des dates peuvent être ajoutées ; les dates existantes ne peuvent pas être modifiées ni supprimées.',

            'generate_days' =>
            'Vous êtes sur le point de générer les jours calendaires du planning ":attribute". Après génération, les jours ouvrables, les périodes de travail et les jours de repos ne pourront plus être modifiés. Souhaitez-vous continuer ?',

            'generate_slots' => [

                'one' =>
                'Êtes-vous sûr de vouloir générer les créneaux pour ":attribute" ? Le jour sélectionné sera verrouillé après génération.',

                'all' =>
                'Êtes-vous sûr de vouloir générer les créneaux pour tous les jours du planning ":attribute" ? Les jours calendaires seront verrouillés après génération et ne pourront pas être modifiés.',
            ],
        ],

        "slot" => [
            "block" => "Rendre ce créneau indisponible ? Les patients ne pourront pas le réserver.",
            "unblock" => "Rendre ce créneau disponible ? Les patients pourront le réserver.",
            "book" => "Veuillez confirmer votre rendez-vous le :date à :start_at.",
        ],
        /*
        |--------------------------------------------------------------------------
        | CONFIRMATIONS DES RÔLES
        |--------------------------------------------------------------------------
        */
        'roles' => [
            'detach' => [
                'coordinator' =>
                'Êtes-vous sûr de vouloir dissocier le coordinateur ":attribute" ?',

                'appointments_location_agent' =>
                'Êtes-vous sûr de vouloir dissocier l\'agent du lieu de rendez-vous ":attribute" ?',

                'doctor' =>
                'Êtes-vous sûr de vouloir dissocier le médecin ":attribute" ?',

                'medical_secretary' =>
                'Êtes-vous sûr de vouloir dissocier la secrétaire médicale ":attribute" ?',
            ],
        ],

        /*
        |--------------------------------------------------------------------------
        | CONFIRMATIONS DE RENDEZ-VOUS
        |--------------------------------------------------------------------------
        */
        'appointment' => [
            'cancel' => 'Confirmer l\'annulation de votre rendez-vous du :date à :start_at ?',
        ],
    ],
];
