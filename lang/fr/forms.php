<?php


return [
    'common' => [
        'actions' => [
            "confirm" => "Oui",
            "cancel" => "Non",
            'submit' => 'Soumettre',
            'reset' => 'Réinitialiser le formulaire',
        ],
        'errors' => [
            "default" => "Une erreur est survenue. Veuillez contacter votre équipe informatique.",
            "not_match" => [
                'phone' => 'Le numéro de téléphone doit commencer par 05, 06 ou 07 et contenir exactement 10 chiffres.',
                "land_line" => "Le numéro de fixe doit commencer par 0 et contenir exactement 9 chiffres"
            ],
            'img' => [
                'not_img' => 'Le fichier doit être une image.',
                "not_imgs" => "Les fichiers doivent être des images",
            ],
            'user' => [
                'not_exists' => 'Le champ :attribute est obligatoire.',
            ],
        ],
    ],

    "period" => [
        "start" => "Heure de début",
        "end" => "Heure de fin",
    ],
    "locations" => [
        "location" => "Lieu de rendez-vous",
        "capacity" => "Médecins disponibles"
    ],
    'site_parameters' => [
        'steps' => [
            'first' => [
                'password' => 'Mot de passe',
                'email' => 'Votre email',
            ],
            'last' => [
                "maintenance" => "Mode maintenance",
                'state' => "État",
                'enable' => "Activer",
                'disable' => "Désactiver",
            ],
        ],
        "actions" => [
            "download_db" => "Télécharger la base de données"
        ],
        'responses' => [
            'you_can_pass' => 'Vous avez les identifiants pour mettre à jour l\'état de l\'application',
            'success' => 'Vous avez mis à jour avec succès l\'état de l\'application',
        ],
        'errors' => [
            'no_access' => "Vous n'avez pas les identifiants nécessaires pour l'étape suivante",
            'user_not_found' => 'Vérifiez votre email et mot de passe et réessayez',
        ],
    ],

    'login' => [

        // Fields
        'login' => "Nom d'utilisateur ou email",
        'email' => 'Email',
        'name' => 'Nom d\'utilisateur',
        'password' => 'Mot de passe',

        'responses' => [
            'success' => 'Connexion réussie.',
        ],
        // Actions
        'actions' => [
            'submit' => 'Connexion',
        ],

        // Errors
        'errors' => [
            'invalid_credentials' => 'Identifiants incorrects.',
            'too_many_attempts' => 'Trop de tentatives. Réessayez plus tard.',
        ],
    ],

    'register' => [

        /*
    |--------------------------------------------------------------------------
    | INSTRUCTIONS
    |--------------------------------------------------------------------------
    */
        'instructions' => [
            'email_optional' => "Nous vous recommandons d'utiliser une adresse email valide. Vous pourriez en avoir besoin pour la vérification ou la récupération de votre compte.",
            'email' => 'Email valide requis. Un code de vérification sera envoyé à votre adresse email.',
            'code' => 'Entrez le code de vérification envoyé à votre email.',
            'password' => 'Minimum 8 caractères requis.',
            'name' => 'Entrez votre prénom et votre nom.',
            'terms' => 'Vous devez accepter les règles de la plateforme avant de continuer.',
        ],

        /*
    |--------------------------------------------------------------------------
    | FIELDS
    |--------------------------------------------------------------------------
    */
        "name" => "Nom d'utilisateur",
        'first_name' => 'Prénom',
        'last_name'  => 'Nom de famille',
        'email'      => 'Adresse email',
        'password'   => 'Mot de passe',
        'code'       => 'Code de vérification',
        'agree_terms' => 'J\'accepte les règles et conditions de la plateforme',

        /*
    |--------------------------------------------------------------------------
    | ACTIONS
    |--------------------------------------------------------------------------
    */
        'actions' => [
            'get_code'     => 'Obtenir le code',
            'get_new_code' => 'Renvoyer le code',
            'submit'       => 'Créer le compte',
        ],

        /*
    |--------------------------------------------------------------------------
    | RESPONSES
    |--------------------------------------------------------------------------
    */
        'responses' => [
            'new_code' => 'Nouveau code de vérification envoyé à votre email.',
            'success'  => 'Compte créé avec succès.',
        ],

        /*
    |--------------------------------------------------------------------------
    | ERRORS
    |--------------------------------------------------------------------------
    */
        'errors' => [
            'verification_code'  => 'Code de vérification invalide ou expiré.',
            'too_many_attempts'  => 'Trop de tentatives d\'inscription. Veuillez réessayer dans quelques minutes.',
        ],
    ],
    'forgot_password' => [
        'instructions' => [
            'email' => 'Entrez votre email pour recevoir un code de vérification.',
            'code' => 'Entrez le code envoyé à votre email.',
        ],
        'email' => 'Adresse email',
        'code' => 'Code de vérification',
        'password' => 'Nouveau mot de passe',
        'actions' => [
            'get_code' => 'Envoyer le code',
        ],
        'responses' => [
            'new_code' => 'Nouveau code de vérification envoyé.',
            'success' => 'Mot de passe réinitialisé avec succès.',
        ],
        'errors' => [
            'no_user' => 'Aucun compte trouvé avec cette adresse email.',
            'verification_code' => 'Code de vérification invalide ou expiré.',
        ],
    ],
    'change_password' => [
        'infos' => [
            'redirect' => 'Après avoir changé votre mot de passe, vous serez déconnecté.',
        ],
        'old_pwd' => 'Votre ancien mot de passe',
        'pwd' => 'Votre nouveau mot de passe',
        'responses' => [
            'success' => 'La modification a été effectuée avec succès. Vous allez être déconnecté maintenant.',
        ],
        'errors' => [
            'old_pwd' => 'Veuillez vérifier votre ancien mot de passe et réessayer.',
            'invalid_current' => "La modification du mot de passe est restreinte aux Super Administrateurs et au propriétaire du compte",
        ],
    ],
    'change_mail' => [
        'infos' => [
            'redirect' => 'Vous serez déconnecté après avoir changé votre email.',
        ],
        'pwd' => 'Mot de passe',
        'mail' => 'Email actuel',
        'new_mail' => 'Nouvel email',
        'responses' => [
            'success' => 'Votre email a été changé avec succès. Vous allez maintenant être déconnecté.',
        ],
        'errors' => [
            'auth' => 'Veuillez vérifier votre email actuel et votre mot de passe et réessayer.',
        ],
    ],
    'general_infos' => [
        'inaugural_year' => "Année d'inauguration",
        'email' => "Adresse email",
        'app_name' => "Nom de l'application",
        'acronym' => "Acronyme de l'institution",
        "address_fr" => "Adresse officielle (Français)",
        "address_en" => "Adresse officielle (Anglais)",
        "address_ar" => "Adresse officielle (Arabe)",
        'logo' => "Logo de l'institution",
        'phone' => "Téléphone principal",
        'landline' => "Numéro de fixe",
        'fax' => "Numéro de fax",
        "theme_color" => "Couleur du thème",
        'map' => "Localisation Google Maps",
        'youtube' => "YouTube",
        'facebook' => "Facebook",
        'linkedin' => "LinkedIn",
        'github' => "GitHub",
        'instagram' => "Instagram",
        'tiktok' => "TikTok",
        'twitter' => "Twitter",
        'threads' => "Threads",
        'snapchat' => "Snapchat",
        'pinterest' => "Pinterest",
        'reddit' => "Reddit",
        'telegram' => "Telegram",
        'whatsapp' => "WhatsApp",
        'discord' => "Discord",
        'twitch' => "Twitch",
        'responses' => [
            'success' => 'Les informations générales de l\'application ont été mises à jour avec succès',
        ],
    ],
    'manage_hero' => [
        'title_ar' => "Titre (AR)",
        'title_fr' => "Titre (FR)",
        'title_en' => "Titre (EN)",
        'sub_title_ar' => "Sous-titre (AR)",
        'sub_title_fr' => "Sous-titre (FR)",
        'sub_title_en' => "Sous-titre (EN)",
        "introduction_fr" => "Introduction (FR)",
        "introduction_ar" => "Introduction (AR)",
        "introduction_en" => "Introduction (EN)",
        "primary_call_to_action_fr" => "CTA principal (FR)",
        "primary_call_to_action_ar" => "CTA principal (AR)",
        "primary_call_to_action_en" => "CTA principal (EN)",
        "secondary_call_to_action_fr" => "CTA secondaire (FR)",
        "secondary_call_to_action_ar" => "CTA secondaire (AR)",
        "secondary_call_to_action_en" => "CTA secondaire (EN)",
        "images" => "Images de la page d'accueil",
        'responses' => [
            'success' => 'Le contenu de la page d\'accueil a été mis à jour avec succès',
        ],
    ],
    'manage_about_us' => [
        "sub_title_fr" => "Sous-titre (Fr)",
        "sub_title_ar" => "Sous-titre (Ar)",
        "sub_title_en" => "Sous-titre (En)",

        'first_paragraph_fr' => "Premier paragraphe (Fr)",
        'first_paragraph_ar' => "Premier paragraphe (Ar)",
        'first_paragraph_en' => "Premier paragraphe (En)",
        'second_paragraph_fr' => "Deuxième paragraphe (Fr)",
        'second_paragraph_ar' => "Deuxième paragraphe (Ar)",
        'second_paragraph_en' => "Deuxième paragraphe (En)",
        'third_paragraph_fr' => "Troisième paragraphe (Fr)",
        'third_paragraph_ar' => "Troisième paragraphe (Ar)",
        'third_paragraph_en' => "Troisième paragraphe (En)",

        "image" => "Image de la section À propos",

        'responses' => [
            'success' => 'Vous avez mis à jour avec succès les informations de la page À propos de votre application',
        ],
    ],

    "user" => [
        'instructions' => [
            "email" => "Adresse email valide obligatoire. Un code de vérification vous sera envoyé.",
        ],
        'email' => "Adresse email",
        "name" => "Nom d'utilisateur",
        'last_name' => "Nom",
        "first_name" => "Prénom",
        'is_active' => 'État du compte',
        "password" => "Mot de passe",
        "person_id" => "Employé",
        "avatar" => "Photo de profil",

        "errors" => [
            'unique_super_admin' => "Impossible de désactiver : dernier super administrateur actif.",
        ],
        'responses' => [
            "add_success" => "Compte créé avec succès",
            "update_success" => "Compte modifié : :name",
        ],
    ],

    'role' => [
        'user_id' => "Compte utilisateur",
        'roles' => "Rôles utilisateur",
        'errors' => [
            'user_id_required' => 'La sélection de l\'utilisateur est requise',
            'user_id_exists'   => 'Le compte utilisateur spécifié n\'existe pas',
            'roles_required'   => 'Au moins un rôle doit être sélectionné',
            'roles_array'      => 'Les rôles doivent être fournis comme identifiants valides',
            'roles_exist'      => 'Un ou plusieurs rôles spécifiés sont invalides',
            'user_not_found'   => 'Le compte utilisateur demandé n\'a pas été trouvé',
            'error_title'      => 'Erreur d\'attribution des rôles',
            'unique_super_admin' => "Vous ne pouvez pas supprimer le rôle de super administrateur pour cet utilisateur car c'est le dernier utilisateur super administrateur.",
        ],
        'responses' => [
            'success'      => 'Les rôles utilisateur ont été mis à jour avec succès',
            'own_success'  => 'Vos rôles ont été mis à jour. Pour des raisons de sécurité, vous avez été déconnecté de toutes les sessions.',
        ],
    ],

    "guest" => [
        "message" => [
            'name' => "Nom",
            'name-placeholder' => "Votre nom",
            'email' => "Email",
            'email-placeholder' => "Votre email",
            "message" => "Message",
            'message-placeholder' => "Votre message",
            "sent" => "Envoyer le message",
            'responses' => [
                'send_success' => 'Votre message a été envoyé avec succès. Une réponse vous sera envoyée à votre adresse email',
            ],
        ]
    ],
    "reply" => [
        "message" => "Message",
        'responses' => [
            'send_success' => 'Votre réponse a été envoyée avec succès au visiteur par email.',
        ],
    ],
    "slide" => [
        'title_fr' => "Titre en français",
        'title_ar' => "Titre en arabe",
        'title_en' => "Titre en anglais",
        "content_fr" => "Contenu en français",
        "content_en" => "Contenu en anglais",
        "content_ar" => "Contenu en arabe",
        "order" => "Ordre de la diapositive",
        "slider_id" => "Diaporama",
        'image' => "Image",
        'responses' => [
            'add_success' => 'Vous avez ajouté avec succès une nouvelle diapositive',
            'update_success' => 'Vous avez mis à jour avec succès la diapositive sélectionnée',
        ],
    ],
    "slider" => [
        "name" => "Titre de la diapositive",
        "position" => "Position d'affichage",
        "user_id" => "Publié par",
        'state' => "Statut de publication",
        'responses' => [
            'add_success' => 'Nouvelle diapositive ajoutée avec succès',
            'update_success' => 'Diapositive sélectionnée mise à jour avec succès',
        ],
    ],

'image' => [
    'display_name' => "Nom d'affichage",
    'use_case' => "Motif",
    'real_image' => "Fichier image",
    'responses' => [
        "add_success" => "Fichier image ajouté avec succès",
        'update_success' => "Le fichier image a été mis à jour avec succès",
    ],
],
'file' => [
    'display_name' => "Nom d'affichage",
    'use_case' => "Motif",
    'real_file' => "Fichier PDF",
    'responses' => [
        "add_success" => "Fichier ajouté avec succès",
        'update_success' => "Le fichier a été mis à jour avec succès",
    ],
],

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// App

    "person" => [
        "last_name_fr" => "Nom de famille (FR)",
        "last_name_ar" => "Nom de famille (AR)",
        "first_name_fr" => "Prénom (FR)",
        "first_name_ar" => "Prénom (AR)",
        "profile_img" => "Photo de profil",
        'is_paid' => 'Statut de paiement',
        'is_active' => 'Statut du compte',
        "cv" => "CV",
        "email" => "Email",
        "card_number" => "Numéro national d'identité",
        "birth_date" => "Date de naissance",
        'birth_place_fr' => "Lieu de naissance (FR)",
        'birth_place_ar' => "Lieu de naissance (AR)",
        "address_fr" => "Adresse (FR)",
        "address_ar" => "Adresse (AR)",
        "address_en" => "Adresse (EN)",
        'phone' => "Téléphone",
        "employee_number" => "Identifiant employé",
        "social_number" => "Numéro de sécurité sociale",
        'responses' => [
            "add_success" => "Dossier personnel créé avec succès",
            "update_success" => "Dossier personnel mis à jour : :name",
        ],
    ],

    "wilaya" => [
        'designation_fr' => "Nom français",
        'designation_ar' => "Nom arabe",
        'designation_en' => "Nom anglais",
        'code' => "Code de la wilaya",
        'responses' => [
            'add_success' => 'Wilaya créée avec succès',
            'update_success' => 'Wilaya mise à jour avec succès',
        ],
    ],

    "daira" => [
        'designation_fr' => "Nom français",
        'designation_ar' => "Nom arabe",
        'designation_en' => "Nom anglais",
        'code' => "Code de la daïra",
        'responses' => [
            'add_success' => 'Daïra créée avec succès',
            'update_success' => 'Daïra mise à jour avec succès',
        ],
    ],

    "commune" => [
        'designation_fr' => "Nom français",
        'designation_ar' => "Nom arabe",
        'designation_en' => "Nom anglais",
        'code' => "Code de la commune",
        'responses' => [
            'add_success' => 'Commune créée avec succès',
            'update_success' => 'Commune mise à jour avec succès',
        ],
    ],

    "field" => [
        'designation_fr' => "Désignation française",
        'designation_ar' => "Désignation arabe",
        'designation_en' => "Désignation anglaise",
        'acronym' => "Acronyme",
        'responses' => [
            'add_success' => 'Domaine professionnel créé avec succès',
            'update_success' => 'Domaine mis à jour avec succès',
        ],
    ],

    "field_grade" => [
        'designation_fr' => "Désignation française",
        'designation_ar' => "Désignation arabe",
        'designation_en' => "Désignation anglaise",
        'acronym' => "Code du grade",
        'field_id' => "Domaine professionnel",
        'responses' => [
            'add_success' => 'Niveau de grade créé avec succès',
            'update_success' => 'Niveau de grade mis à jour avec succès',
        ],
    ],

    "field_specialty" => [
        'designation_fr' => "Désignation française",
        'designation_ar' => "Désignation arabe",
        'designation_en' => "Désignation anglaise",
        'acronym' => "Code de spécialité",
        'field_id' => "Domaine professionnel",
        'responses' => [
            'add_success' => 'Spécialité professionnelle créée avec succès',
            'update_success' => 'Spécialité mise à jour avec succès',
        ],
    ],

    "occupation" => [
        'field_id' => "Domaine professionnel",
        'field_specialty_id' => "Domaine de spécialisation",
        'field_grade_id' => "Grade professionnel",
        "description_fr" => "Description professionnelle (Français)",
        "description_en" => "Description professionnelle (Anglais)",
        "description_ar" => "Description professionnelle (Arabe)",
        "experience" => "Années d'expérience professionnelle",
        'errors' => [
            'field_required' => 'La sélection du domaine professionnel est requise',
            'field_exists' => 'Le domaine professionnel sélectionné est invalide',
            'field_specialty_exists' => 'Le domaine de spécialisation sélectionné est invalide',
            'field_grade_exists' => 'Le grade professionnel sélectionné est invalide',
        ],
        'responses' => [
            'add_success' => 'L\'occupation professionnelle a été ajoutée avec succès',
            'update_success' => 'L\'occupation professionnelle a été mise à jour avec succès',
        ],
    ],




    'establishment' => [


        'acronym' => 'Acronyme',

        'name_fr' => 'Nom (FR)',
        'name_en' => 'Nom (EN)',
        'name_ar' => 'Nom (AR)',

        'email' => 'Adresse email',

        'address_fr' => 'Adresse (FR)',
        'address_en' => 'Adresse (EN)',
        'address_ar' => 'Adresse (AR)',

        'description_fr' => 'Description (FR)',
        'description_en' => 'Description (EN)',
        'description_ar' => 'Description (AR)',

        'tel' => 'Numéro de téléphone',
        'fax' => 'Numéro de fax',

        'daira_id' => 'Daïra',

        'longitude' => 'Longitude',
        'latitude' => 'Latitude',

        'types' => 'Types d\'établissement',


        'instructions' => [
            'types' => 'Sélectionnez un ou plusieurs types d\'établissement (ex. class_a, appointments_location).',
        ],

        'responses' => [
            'add_success' => 'L\'établissement a été créé avec succès.',
            'update_success' => 'L\'établissement a été mis à jour avec succès.',
            'delete_success' => 'L\'établissement a été supprimé avec succès.',
        ],

        'errors' => [
            'not_found' => 'L\'établissement demandé n\'a pas été trouvé.',
            'invalid_types' => 'Un ou plusieurs types sélectionnés sont invalides.',
            'required_daira' => 'Veuillez sélectionner une daïra valide.',
        ],
    ],

    'appointment' => [
        "patient_id" => "Patient",
        "schedule_day_id" => "Jour planifié",
        'appointments_location_id' => "Lieu de rendez-vous",
        "specialty_id" => "Spécialité médicale",
        "day_at" => "Date du rendez-vous",
        "status" => "Statut du rendez-vous",
        "referral_letter" => "Lettre d'orientation (Format image)",
        "referral_letter_short" => "Lettre d'orientation",

        'information' => [
            'title' => 'Pour procéder à la réservation de votre rendez-vous, veuillez fournir les informations requises suivantes :',

            'specialty' => 'Veuillez sélectionner une spécialité médicale pour votre consultation',

            'referral_letter' => 'Une lettre d\'orientation est nécessaire pour finaliser votre demande',
        ],
        'responses' => [
            'add_success' => 'Rendez-vous réservé avec succès.',
        ],

        'errors' => [
            'not_found' => [
                'patient' => 'Patient introuvable.',
                'schedule_slot' => 'Créneau de planning introuvable.',
                'schedule_day' => 'Jour de planning introuvable.',
                'specialty' => 'Spécialité introuvable.',
            ],

            // --------------------
            // BUSINESS RULE ERRORS
            // --------------------

            'invalid_slot_day_match' => 'Le créneau horaire sélectionné ne correspond pas au jour sélectionné.',

            'invalid_specialty_for_service' => 'La spécialité sélectionnée ne correspond pas au service de ce planning.',

            'min_gap_days' => 'Vous devez attendre au moins :days jours avant de réserver à nouveau. Votre dernier rendez-vous était le :last, et la date sélectionnée est le :date.',
        ],
    ],
    'establishment' => [
        "acronym" => "Acronyme de l'établissement",
        "name_fr" => "Nom de l'établissement (Français)",
        "name_ar" => "Nom de l'établissement (Arabe)",
        "name_en" => "Nom de l'établissement (Anglais)",
        "email" => "Adresse email",
        "address_fr" => "Adresse complète (Français)",
        "address_ar" => "Adresse complète (Arabe)",
        "address_en" => "Adresse complète (Anglais)",
        "description_fr" => "Description de l'établissement (Français)",
        "description_ar" => "Description de l'établissement (Arabe)",
        "description_en" => "Description de l'établissement (Anglais)",
        "tel" => "Numéro de téléphone principal",
        "fax" => "Numéro de fax",
        'capacity' => "Capacité maximale",
        'daira_id' => "District administratif",
        'longitude' => "Longitude",
        'latitude' => "Latitude",
        'responses' => [
            'add_success' => "Nouvel établissement enregistré avec succès",
            'update_success' => "Les informations de l'établissement ont été mises à jour avec succès",
        ],
    ],

    'service' => [
        "name_fr" => "Nom du département (Français)",
        "name_ar" => "Nom du département (Arabe)",
        "name_en" => "Nom du département (Anglais)",
        "specialty" => "Spécialité médicale",
        "type" => "Type de département",
        "tel" => "Téléphone principal",
        "fax" => "Fax",
        "head_of_service_id" => "Chef de département",
        "establishment_id" => "Établissement affilié",

        'responses' => [
            'add_success' => "Département hospitalier créé avec succès",
            'update_success' => "Département mis à jour avec succès",
        ],
    ],

    'coordinator' => [
        'user_id' => 'Nom du coordinateur',
        'responses' => [
            'add_success' => 'Coordinateur ajouté avec succès',
        ],
    ],
    'doctor' => [
        'user_id' => 'Nom du médecin',
        'responses' => [
            'add_success' => 'Médecin ajouté avec succès',
        ],
    ],

    'medical_secretary' => [
        'user_id' => 'Nom de la secrétaire médicale',
        'responses' => [
            'add_success' => 'Secrétaire médicale ajoutée avec succès',
        ],
    ],
    "appointments_location_agent" => [
        "user_id" => "Nom de l'employé",
        "appointments_location_id" => "Lieu de rendez-vous",
        'responses' => [
            'add_success' => "Administrateur du lieu de rendez-vous ajouté avec succès",
        ],
    ],

    'medical_file' => [
        "last_name_fr" => "Nom de famille (Fr)",
        "first_name_fr" => "Prénom (Fr)",
        "last_name_ar" => "Nom de famille (Ar)",
        "first_name_ar" => "Prénom (Ar)",
        'gender' => "Genre",
        "code" => "Code patient",
        "birth_place_fr" => "Lieu de naissance (Fr)",
        "birth_place_ar" => "Lieu de naissance (Ar)",
        "birth_place_en" => "Lieu de naissance (En)",
        "birth_date" => "Date de naissance",
        "address_fr" => "Adresse complète (Fr)",
        "address_ar" => "Adresse complète (Ar)",
        "address_en" => "Adresse complète (En)",
        "tel" => "Numéro de téléphone",
        "opened_by" => "Créé par",
        "insurance_number" => "Numéro de police d'assurance",
        'responses' => [
            'add_success' => "Nouveau dossier médical créé avec succès",
            'update_success' => "Dossier médical mis à jour avec succès",
        ],
    ],

    'rating' => [
        'doctor_id' => "Médecin",
        'user_id' => "Patient",
        'rating' => "Note (1-5)",
        'comment_fr' => "Commentaire (Français)",
        'comment_ar' => "Commentaire (Arabe)",
        'comment_en' => "Commentaire (Anglais)",

        'responses' => [
            'add_success' => "Nouvelle note soumise avec succès",
            'update_success' => "Votre note a été mise à jour avec succès",
        ],
    ],


'schedule' => [

    // =========================
    // INFORMATION (LOCK RULES)
    // =========================
    "information" => [
        "locked" => [

            "service_in_inactive_state" =>
            "Ce planning est verrouillé car le service est inactif.",

            "service_manager_only_own" =>
            "Les gestionnaires de service ne peuvent modifier que les plannings qu'ils ont créés.",

            "service_manager_only_published" =>
            "Les gestionnaires de service ne peuvent modifier que les plannings publiés.",

            "coordinator_restriction" =>
            "Vous n'êtes pas autorisé à modifier ce planning en raison des restrictions du coordinateur.",

            "default_only_draft" =>
            "Ce planning est verrouillé car seuls les plannings en mode brouillon peuvent être modifiés.",

            "not_allowed_to_update" =>
            "Vous ne pouvez pas modifier ce planning en raison de votre rôle, du contexte du service ou de l'état du planning.",
        ],
    ],

    // =========================
    // CORE FIELDS (FULLY COMPLETE)
    // =========================
    "year" => "Année calendaire",
    "month" => "Mois",

    "name_fr" => "Nom du planning (Fr)",
    "name_en" => "Nom du planning (En)",
    "name_ar" => "Nom du planning (Ar)",

    "description_fr" => "Description du planning (Fr)",
    "description_ar" => "Description du planning (Ar)",
    "description_en" => "Description du planning (En)",

    "state" => "Statut",
    'appointment_duration' => "Durée du rendez-vous",

    "service_id" => "Service médical",
    "opened_by" => "Créé par",

    // =========================
    // WORKING RULES LABELS
    // =========================
    "working_days" => "Jours ouvrables",
    "days_off" => "Jours de repos",
    "working_periods" => "Périodes de travail",
    "appointments_locations" => "Lieux de rendez-vous",

    // =========================
    // RESPONSES
    // =========================
    "responses" => [
        "add_success" =>
        "Un nouveau planning a été créé avec succès.",

        "update_success" =>
        "Le planning a été mis à jour avec succès.",
    ],

    // =========================
    // ERRORS
    // =========================
    "errors" => [

        'multiple_location_selection' => 'Vous ne pouvez pas sélectionner le même lieu plusieurs fois.',
        // -------------------------
        // WORKING PERIODS
        // -------------------------
        "working_periods" => [
            "start_required" =>
            "Article n° :item_number : l'heure de début est requise.",

            "end_required" =>
            "Article n° :item_number : l'heure de fin est requise.",

            "invalid_time" =>
            "L'article n° :item_number a une plage horaire invalide.",

            "start_after_end" =>
            "Article n° :item_number : l'heure de début doit être antérieure à l'heure de fin.",
        ],

        // -------------------------
        // APPOINTMENT LOCATIONS
        // -------------------------
        "locations" => [
            "location_required" =>
            "Article n° :item_number : le lieu est requis.",

            "capacity_required" =>
            "Article n° :item_number : la capacité est requise.",

            "capacity_min" =>
            "Article n° :item_number : la capacité doit être d'au moins 1.",

            "duplicate_location" =>
            "Article n° :item_number : ce lieu est déjà sélectionné.",

            "invalid_location" =>
            "Article n° :item_number : le lieu sélectionné est invalide.",
        ],

        // -------------------------
        // GENERAL VALIDATION
        // -------------------------
        "validation" => [
            "invalid_service" => "Le service sélectionné est invalide.",
            "invalid_year" => "L'année n'est pas valide.",
            "invalid_month" => "Le mois n'est pas valide.",

            "working_days_required" => "Au moins un jour ouvrable doit être sélectionné.",
        ],

        // -------------------------
        // NOT FOUND / BUSINESS RULES
        // -------------------------
        "not_found" => [
            "creator" =>
            "Un coordinateur de service est requis pour créer un planning.",

            "service" =>
            "Un service est requis pour créer un planning.",

            "schedule" =>
            "Planning non trouvé.",
        ],
    ],
],

'schedule_day' => [
    "state" => "Statut",
    'appointment_duration' => "Durée du rendez-vous",

    "day_at" => "Jour",

    "working_periods" => "Périodes de travail",
    "appointments_locations" => "Lieux de rendez-vous",

    // =========================
    // RESPONSES
    // =========================
    "responses" => [
        "add_success" =>
        "La nouvelle date de planning a été créée avec succès.",

        "update_success" =>
        "La date de planning a été mise à jour avec succès.",
    ],
],

    'patient' => [
        'code' => 'Code patient',

        'first_name_fr' => 'Prénom (FR)',
        'first_name_ar' => 'Prénom (AR)',

        'last_name_fr' => 'Nom de famille (FR)',
        'last_name_ar' => 'Nom de famille (AR)',

        'gender' => 'Genre',

        'birth_date' => 'Date de naissance',

        'birth_place_fr' => 'Lieu de naissance (FR)',
        'birth_place_ar' => 'Lieu de naissance (AR)',
        'birth_place_en' => 'Lieu de naissance (EN)',

        'address_fr' => 'Adresse (FR)',
        'address_ar' => 'Adresse (AR)',
        'address_en' => 'Adresse (EN)',

        'commune_id' => 'Commune',
        'daira' => 'Daïra',

        'father_id' => 'Père',
        'mother_id' => 'Mère',

        'tel' => 'Numéro de téléphone',

        'insurance_number' => 'Numéro d\'assurance',

        'opened_by' => 'Créé par',

        'responses' => [
            'add_success' => 'Patient créé avec succès.',
            'update_success' => 'Patient mis à jour avec succès.',
        ],
    ],
'medical_exam' => [
    'patient_id' => "Patient",
    'doctor_id' => "Médecin",
    "specialty_id" => "Spécialité médicale",
    'report_fr' => "Rapport d'examen (FR)",
    'report_ar' => "Rapport d'examen (AR)",
    'report_en' => "Rapport d'examen (EN)",
    'responses' => [
        "add_success" => "Rapport d'examen médical ajouté avec succès.",
        'update_success' => "Rapport d'examen médical mis à jour avec succès.",
    ],
],
];
