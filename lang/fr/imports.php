<?php

return [
    "line_number_error" => "Erreur à la ligne numéro (:number)",
    'users' => [
        'nom_d_utilisateur' => 'Nom d\'utilisateur',
        'e_mail' => 'Adresse email',
    ],

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////               App

    'supplier' => [

        'name' => 'nom',
        'code' => 'code',
        'person_to_contact' => 'personne à contacter',
        'email' => 'email',
        'phone' => 'téléphone',
        'fax' => 'fax',
        'address' => 'adresse',
        'wilaya' => 'wilaya',
        'nis' => 'nis',
        'nif' => 'nif',
        'rc' => 'rc',
        'is_active' => 'actif',

        'wilaya_invalid' => 'La wilaya doit être un code ou un nom valide (FR / EN / AR).',

        'success' => [
            'import' => 'Les fournisseurs ont été importés avec succès',
        ],

        'errors' => [
            'duplicate_name' => 'Un fournisseur avec ce nom existe déjà',
            'duplicate_code' => 'Un fournisseur avec ce code existe déjà',
            'duplicate_phone' => 'Un fournisseur avec ce téléphone existe déjà',
            'duplicate_fax' => 'Un fournisseur avec ce fax existe déjà',
        ],
    ],
'store' => [
    'name' => 'name',
    'code' => 'code',
    'type' => 'type',
    'location' => 'location',
    'is_active' => 'active',
    'type_invalid' => 'The store type is invalid.',
],

"article" => [
    /* ---------- Fields ---------- */
    "name" => "Nom",
    "code" => "Code",
    "description" => "Description",

    "category" => "Catégorie",
    "measurement_unit" => "Unité de mesure",

    "min_quantity" => "Quantité minimale",
    "max_quantity" => "Quantité maximale",

    "is_active" => "Actif",

    'errors' => [
        /* ---------- Validation Errors ---------- */
        "category_invalid" => "Catégorie invalide",
        "measurement_unit_invalid" => "Unité de mesure invalide",

        /* ---------- Optional (recommended for future) ---------- */
        "already_exists" => "Ce produit existe déjà",
    ],

    'success' => [
        'import' => 'Produits importés avec succès',
    ],
],
];
