<?php

return [
    "common" => [
        "excel-file-type-err" => "Le fichier doit être au format Excel (XLSX, XLS, CSV)",
        "actions" => "Actions",
        "perPage" => "Par page"
    ],

    'images' => [
        "info" => "Liste des fichiers image",
        "not_found" => "Aucun fichier image trouvé",
        'display_name' => "Nom d'affichage",
        "use_case" => "Cas d'utilisation",
        'created_at' => "Ajouté le",
        'preview' => "Aperçu",
    ],
    'files' => [
        "info" => "Liste des fichiers PDF",
        "not_found" => "Aucun fichier PDF trouvé",
        'display_name' => "Nom d'affichage",
        "use_case" => "Cas d'utilisation",
        'created_at' => "Ajouté le",
        'preview' => "Aperçu",
        "download" => "Télécharger le fichier"
    ],

    'users' => [
        "info" => 'Registre des utilisateurs',

        "not_found" => "Aucun utilisateur disponible",
        "name" => "Nom d'utilisateur",
        "last_name" => "Nom de famille",
        "first_name" => "Prénom",
        "fullName" => "Nom complet",
        "email" => "Adresse email",
        "avatar" => "Photo de profil",
        "registration_date" => "Compte créé le",

        "excel" => [
            "upload" => [
                "success" => "Utilisateurs importés avec succès"
            ]
        ]
    ],

    'messages' => [
        'info' => 'Messages des visiteurs',
        'not_found' => 'Aucun message de visiteur trouvé pour le moment',
        'name' => 'Nom',
        'email' => 'Email',
        'created_at' => 'Date de réception',
    ],

    'sliders' => [
        "info" => "Liste des sliders",
        "not_found" => "Aucun slider trouvé",
        "created_at" => "Ajouté le",
        'creator' => "Créateur",
        'name' => "Nom",
        "position" => "Position",
        "location" => "Localisation",
        "state" => "Statut",
    ],
    "slides" => [
        "info" => "Liste des sliders",
        "not_found" => "Aucun slider trouvé pour le moment",
        "created_at" => "Ajouté le",
        'title' => "Titre",
        'order' => 'Ordre',
        'image' => "Image",
        "location" => "Localisation",
        "state" => "État",
    ],

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// App
    'persons' => [
        "info" => "Registre du personnel",
        "empty" => "Aucun dossier personnel trouvé",
        "full_name" => "Nom complet",
        "full_name_fr" => "Nom complet (FR)",
        "full_name_ar" => "Nom complet (AR)",
        "employee_number" => "Identifiant employé",
        "social_number" => "Numéro de sécurité sociale",
        "email" => "Email officiel",
        "registration_date" => "Date d'enregistrement",
        "phone" => "Téléphone",
        "card_number" => "Numéro national d'identité",
        "bank_acronym" => "Banque",
        "bank_account" => "Compte bancaire",
        "birth_date" => "Date de naissance",
        "birth_place_fr" => "Lieu de naissance (FR)",
        "birth_place_ar" => "Lieu de naissance (AR)",
        "birth_place_en" => "Lieu de naissance (EN)",
        "excel" => [
            "upload" => [
                "success" => "Dossiers du personnel importés avec succès"
            ]
        ]
    ],


    'wilayates' => [
        "info" => "Liste des wilayas",
        "not_found" => "Aucune wilaya trouvée pour le moment",
        "code" => "Code",
        "designation" => "Désignation",
        "designation_fr" => "Désignation (Français)",
        "designation_ar" => "Désignation (Arabe)",
        "designation_en" => "Désignation (Anglais)",
        "registration_date" => "Date d'enregistrement",
        "excel" => [
            "upload" => [
                "success" => "Liste des wilayas téléchargée avec succès"
            ]
        ]
    ],



    'dairates' => [
        "info" => "Daïras de :name",
        "not_found" => "Aucune daïra disponible pour le moment",
        "code" => "Code de la daïra",
        "designation" => "Nom de la daïra",
        "designation_fr" => "Nom français",
        "designation_ar" => "Nom arabe",
        "designation_en" => "Nom anglais",
        "registration_date" => "Date d'enregistrement",
        "excel" => [
            "upload" => [
                "success" => "Données des daïras importées avec succès"
            ]
        ]
    ],

    'communes' => [
        "info" => "Communes de :name",
        "not_found" => "Aucune commune disponible pour le moment",
        "code" => "Code de la commune",
        "designation" => "Nom de la commune",
        "designation_fr" => "Nom français",
        "designation_ar" => "Nom arabe",
        "designation_en" => "Nom anglais",
        "registration_date" => "Date d'enregistrement",
        "excel" => [
            "upload" => [
                "success" => "Données des communes importées avec succès"
            ]
        ]
    ],

    'fields' => [
        "info" => "Liste des domaines",
        "not_found" => "Aucun domaine trouvé pour le moment",
        "acronym" => "Acronyme",
        "designation" => "Désignation",
        "designation_fr" => "Désignation (Français)",
        "designation_ar" => "Désignation (Arabe)",
        "designation_en" => "Désignation (Anglais)",
        "registration_date" => "Date d'enregistrement",
        "excel" => [
            "upload" => [
                "success" => "Liste des domaines téléchargée avec succès"
            ]
        ]
    ],

    'field_grades' => [
        "info" => "Niveaux de grade pour le domaine : :acronym",
        "not_found" => "Aucun niveau de grade disponible pour le moment",
        "acronym" => "Code du grade",
        "designation" => "Titre du grade",
        "designation_fr" => "Titre français",
        "designation_ar" => "Titre arabe",
        "designation_en" => "Titre anglais",
        "registration_date" => "Date d'enregistrement",
        "excel" => [
            "upload" => [
                "success" => "Niveaux de grade importés avec succès"
            ]
        ]
    ],

    'field_specialties' => [
        "info" => "Spécialités professionnelles : :acronym",
        "not_found" => "Aucune spécialité disponible pour le moment",
        "acronym" => "Code de spécialité",
        "designation" => "Titre de spécialisation",
        "designation_fr" => "Titre français",
        "designation_ar" => "Titre arabe",
        "designation_en" => "Titre anglais",
        "registration_date" => "Date d'enregistrement",
        "excel" => [
            "upload" => [
                "success" => "Spécialisations importées avec succès"
            ]
        ]
    ],

    'occupations' => [
        "info" => "Liste des occupations",
        "info_custom" => "Liste des occupations de :name",
        "not_found" => "Aucune occupation trouvée pour le moment",
        "is_active" => "État",
        "entitled" => "Intitulé",
        "field" => "Domaine",
        "experience" => "Expérience",
        "specialty" => "Spécialité",
        "grade" => "Grade",
        "created_at" => "Ajouté le",
    ],


    'establishments' => [
        "info" => "Établissements",
        "empty" => "Aucun établissement",
        "not_found" => "Aucun établissement",

        "acronym" => "Sigle",
        "name" => "Nom",
        "name_fr" => "Nom (FR)",
        "name_ar" => "Nom (AR)",
        "name_en" => "Nom (EN)",

        "email" => "Email",
        "tel" => "Tél.",
        "fax" => "Fax",
        "daira" => "Daïra",
        "created_at" => "Créé",

        "longitude" => "Long.",
        "latitude" => "Lat.",

        "excel" => [
            "upload" => [
                "success" => "Importation réussie"
            ]
        ],

        "success" => [
            "delete" => "Supprimé",
            "update" => "Modifié",
            "create" => "Créé",
        ],

        "errors" => [
            "default" => "Erreur, veuillez réessayer",
            "not_found" => [
                "establishment" => "Établissement introuvable",
            ],
        ],
    ],

    'services' => [
        "info" => "Liste des départements de l'établissement",
        "not_found" => "Aucun département enregistré pour le moment",
        "created_at" => "Date d'enregistrement",
        "name" => "Nom du département",
        "name_fr" => "Nom du département (Français)",
        "name_en" => "Nom du département (Anglais)",
        "name_ar" => "Nom du département (Arabe)",
        "tel" => "Téléphone principal",
        "fax" => "Fax",
        "head_service" => "Chef de département",
        "establishment" => "Établissement parent",
        "type" => "Type de département",
        "specialty" => "Spécialité médicale",
        "excel" => [
            "upload" => [
                "success" => "Départements importés avec succès"
            ]
        ]
    ],
    'coordinators' => [
        "name" => "Nom",
        "email" => "Email",
        'not_found' => "Aucun coordinateur"
    ],

    "appointments_location_admins" => [
        "name" => "Nom",
        "email" => "Email",
        'not_found' => "Aucun responsable de site"
    ],

    'doctors' => [
        'name' => 'Médecin',
        'email' => 'Email',
        'not_found' => 'Aucun médecin',
    ],

    'medical_secretaries' => [
        'name' => 'Secrétaire',
        'email' => 'Email',
        'not_found' => 'Aucune secrétaire',
    ],
    "appointments_locations_agents" => [
    "name" => "Nom",
    'location' => "Lieu de rendez-vous",
    "email" => "Email officiel",
    'not_found' => "Aucun agent de lieu de rendez-vous trouvé"
],
    "available_appointments" => [
        "info" => [
            "follow-ups" => "Rendez-vous de suivi pour le patient : :code",
            "initials" => "Rendez-vous disponibles - Veuillez sélectionner la date souhaitée",
        ],
        "not_found" => "Aucun rendez-vous disponible actuellement. Veuillez vérifier les champs du formulaire ou réessayer plus tard",
        "date_at" => "Date du rendez-vous",
        "daira" => "Daïra",
        "doctor" => "Médecin assigné",
        "appointments_location" => "Lieu de rendez-vous",
    ],

    "confirmed_appointments" => [
        "info" => "Rendez-vous confirmés",
        "not_found" => "Aucun rendez-vous disponible actuellement. Veuillez vérifier les filtres ou réessayer plus tard",
        "queue_number" => "Numéro de file d'attente",
        "patient" => "Nom du patient",
        "patient_code" => "Code patient",
        "patient_birth_date" => "Date de naissance",
        "patient_tel" => "Téléphone",
        "year" => "Année",
        "month" => "Mois",
        "specialty" => "Spécialité",
        "doctor" => "Médecin",
        "doctor_name" => "Médecin",
        'daira' => "Daïra",
        "location" => "Lieu de rendez-vous",
        "schedule_day" => "Date du rendez-vous",
        "date" => "Date du rendez-vous",
        "type" => "Type",
        "referral_letter" => "Lettre d'orientation"
    ],

    "patient_visits" => [
        "info" => "Liste des rapports de visites patients",
        "not_found" => "Aucun rapport de visite patient disponible. Veuillez vérifier les filtres ou réessayer plus tard",
        "patient" => "Nom du patient",
        "patient_code" => "Code patient",
        'doctor' => "Médecin",
        "created_at" => "Date de création",
    ],

    'medical_files' => [
        "info" => "Dossiers médicaux de mes proches",
        "not_found" => "Aucun dossier médical disponible pour le moment",
        "code" => "Code",
        'name' => "Nom",
        'year' => "Année",
        "last_name_fr" => "Nom de famille (Fr)",
        "last_name_ar" => "Nom de famille (Ar)",
        "first_name_fr" => "Prénom (Fr)",
        "first_name_ar" => "Prénom (Ar)",
        "insurance_number" => "Numéro d'assurance",
        'gender' => "Genre",
        "birth_date" => "Date de naissance",
        "tel" => "Numéro de téléphone",
        'created_at' => "Date de création du dossier"
    ],

    'ratings' => [
        "info" => "Évaluations des patients pour le Dr. :doctor",
        "not_found" => "Aucune évaluation patient disponible pour le moment",
        'doctor' => "Médecin",
        'user_id' => "Patient",
        'rating' => "Score de satisfaction patient (1-5)",
        'created_at' => "Date d'évaluation"
    ],
    'schedules' => [
        "info" => "Liste des plannings des services",
        "not_found" => "Aucun planning trouvé",

        "year" => "Année",
        "month" => "Mois",
        "name" => "Désignation",
        "name_fr" => "Désignation (Fr)",
        "name_en" => "Désignation (En)",
        "name_ar" => "Désignation (Ar)",

        "state" => "Statut de publication",
        "created_at" => "Date de création",
        "service" => "Service médical",
        "created_by" => "Créé par",

        "errors" => [
            "no_days_found" => "Ce planning n'a pas de jours générés. Veuillez d'abord générer les jours.",
            "missing_slots" => "Un ou plusieurs jours du planning n'ont pas de créneaux horaires.",
            "slot_not_found" => "Certains créneaux du planning sont manquants ou n'ont pas été générés correctement.",
            "invalid_booking_data" => "Données de réservation fournies invalides.",
        ],
        "success" => [
            "generate" => "Vous avez généré avec succès les jours du planning :name."
        ]
    ],
    'schedule_days' => [
        "info" => "Liste des jours de planning",
        "not_found" => "Aucun jour de planning trouvé",

        "day_at" => "Date",
        "schedule" => "Planning",
        "specialty" => "Spécialité",
        "slots" => "Nombre de créneaux",

        "appointment_duration" => "Durée du rendez-vous",
        "working_periods" => "Périodes de travail",
        "appointments_locations" => "Lieux de rendez-vous",

        "locked" => "Statut verrouillé",
        "created_at" => "Date de création",

        "errors" => [
            "no_days_found" => "Aucun jour de planning n'a été trouvé pour ce planning.",
            "missing_periods_or_locations" => "Ce jour de planning est dépourvu de périodes de travail ou de lieux de rendez-vous.",
            "locked" => "Ce jour de planning est verrouillé et ne peut pas être modifié.",
            "published" => "Ce planning est déjà publié et ne peut pas être modifié.",
            "invalid_generation" => "Impossible de générer les données du jour de planning.",
            "missing_slots" => "Ce jour de planning n'a pas de créneaux générés.",
            "slot_generation_failed" => "Échec de la génération des créneaux horaires pour ce jour de planning.",
        ],

        'success' => [
            'slots_for_all' => 'Créneaux générés avec succès pour tous les jours de planning.',
            'slot_for_one' => 'Créneaux générés avec succès.',
        ],
    ],

    'schedule_slots' => [
        "info" => "Liste des créneaux de planning pour la date :date",
        "not_found" => "Aucun créneau de planning trouvé",

        "day_at" => "Date",
        "start_at" => "Heure de début",
        "end_at" => "Heure de fin",
        "duration" => "Durée",

        "status" => "Statut du créneau",
        "status_available" => "Disponible",
        "status_booked" => "Réservé",
        "status_blocked" => "Bloqué",

        "schedule_day" => "Jour de planning",
        "specialty" => "Spécialité",
        "appointments_location" => "Lieu de rendez-vous",

        "daira" => "Daïra",

        "created_at" => "Date de création",

        "errors" => [
            "not_found" => "Ce créneau de planning n'a pas été trouvé.",
            "already_booked" => "Ce créneau est déjà réservé et ne peut pas être modifié.",
            "blocked" => "Ce créneau est bloqué et ne peut pas être utilisé.",
            "invalid_time_range" => "Plage horaire invalide pour ce créneau.",
            "overlap" => "Ce créneau chevauche un créneau existant.",
            "generation_failed" => "Échec de la génération des créneaux de planning.",
            "missing_schedule_day" => "Ce créneau n'a pas de jour de planning associé.",
        ],

        "success" => [
            "blocked" => "Créneau bloqué avec succès.",
            "unblocked" => "Créneau débloqué avec succès.",
            "generated" => "Créneaux générés avec succès.",
            "updated" => "Créneau mis à jour avec succès.",
        ],
    ],

    "patients" => [
        "info" => [
            "relatives" => "Liste des proches",
            "patients" => "Liste des patients",
        ],
        "not_found" => [
            "relatives" => "Aucun proche trouvé pour le moment",
            "patients" => "Aucun patient trouvé pour le moment"
        ],
        "code" => "Code patient",
        "name" => "Nom complet",
        "gender" => "Genre",
        "full_name" => "Nom complet",
        "tel" => "Numéro de téléphone",
        "birth_date" => "Date de naissance",
        "commune" => "Commune",
        "appointments" => "Nombre de rendez-vous"
    ],
    'visits' => [
        "info" => "Registre des visites patients",
        "not_found" => "Aucune visite enregistrée",
        'appointment' => "Référence du rendez-vous",
        "code" => "Identifiant patient",
        'patient' => "Nom du patient",
        'doctor' => "Médecin traitant",
        "date" => "Date de consultation"
    ],

    'appointments' => [
        'info' => [
            "relative" => "Rendez-vous de :name",
            'patients' => "Rendez-vous des patients"
        ],
        'not_found' => 'Aucun rendez-vous trouvé pour le moment',
        'year' => 'Année',
        'month' => 'Mois',
        'patient' => 'Patient',
        'code' => 'Code',
        'specialty' => 'Spécialité',
        'service' => 'Département',
        'daira' => 'Daïra',
        'location' => 'Lieu de rendez-vous',
        'date' => 'Date',
        'start_at' => 'Heure de début',
        'type' => 'Type',
        // Excel / export headers
        'queue' => 'File d\'attente',

        'errors' => [
            "cannot_cancel_less_than_3_days" => 'Les rendez-vous ne peuvent pas être annulés moins de 3 jours avant la date prévue',
            "missing_coordinates" => "Les coordonnées du lieu de rendez-vous sont manquantes"
        ],
        "success" => [
            "cancel" => "Vous avez annulé votre rendez-vous avec succès"
        ]
    ],

    'medical_exams' => [
    'info' => 'Historique des examens médicaux',
    'not_found' => 'Aucun historique d\'examens médicaux trouvé pour le moment',
    'patient' => 'Nom du patient',
    'patient_code' => 'Code patient',
    "patient_tel" => "Téléphone du patient",
    "created_at" => "Date de l'examen",
    'specialty' => "Spécialité de l'examen",
    'doctor' => "Médecin",
],
];
