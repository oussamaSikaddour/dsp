<?php
return [
    "line_number_error" => "Error in line number (:number) ",
    'users' => [
        'nom_d_utilisateur' => 'Username',
        'e_mail' => 'Email Address',
    ],



    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////               App

      'supplier' => [

        'name' => 'name',
        'code' => 'code',
        'person_to_contact' => 'person to contact',
        'email' => 'email',
        'phone' => 'phone',
        'fax' => 'fax',
        'address' => 'address',
        'wilaya' => 'wilaya',
        'nis' => 'nis',
        'nif' => 'nif',
        'rc' => 'rc',
        'is_active' => 'active',

        'wilaya_invalid' => 'The wilaya must be a valid code or name (FR / EN / AR).',

        'success' => [
            'import' => 'Suppliers imported successfully',
        ],

        'errors' => [
            'duplicate_name' => 'A supplier with this name already exists',
            'duplicate_code' => 'A supplier with this code already exists',
            'duplicate_phone' => 'A supplier with this phone already exists',
            'duplicate_fax' => 'A supplier with this fax already exists',
        ],
    ],

    'store' => [
    'name' => 'nom',
    'code' => 'code',
    'type' => 'type',
    'location' => 'emplacement',
    'is_active' => 'actif',
    'type_invalid' => 'Le type du magasin est invalide.',
],



"article" => [
    /* ---------- Fields ---------- */
    "name" => "Name",
    "code" => "Code",
    "description" => "Description",

    "category" => "Category",
    "measurement_unit" => "Measurement Unit",

    "min_quantity" => "Minimum Quantity",
    "max_quantity" => "Maximum Quantity",

    "is_active" => "Active",

    'errors' => [
        /* ---------- Validation Errors ---------- */
        "category_invalid" => "Invalid category",
        "measurement_unit_invalid" => "Invalid measurement unit",

        /* ---------- Optional (recommended for future) ---------- */
        "already_exists" => "This product already exists",
    ],

    'success' => [
        'import' => 'Products imported successfully',
    ],
],
];
