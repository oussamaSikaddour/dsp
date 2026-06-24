<?php

return [

    /*
    |--------------------------------------------------------------------------
    | TITLES (UI ACTION LABELS)
    |--------------------------------------------------------------------------
    */

    'title' => [

        /*
        |--------------------------------------------------------------------------
        | DELETE ACTIONS
        |--------------------------------------------------------------------------
        */
        'delete' => [

          "image"=>"Delete Image",
          "file"=>"Delete File",
            // Generic
            'user' => 'Delete User',
            'message' => 'Delete Message',
            'slider' => 'Delete Slider',
            'slide' => 'Delete Slide',

            // App structure
            'establishment' => 'Delete Establishment',
            'wilaya' => 'Delete State',
            'daira' => 'Delete District',
            'commune' => 'Delete Municipality',

            // Professional structure
            'field' => 'Delete Professional Field',
            'field_grade' => 'Delete Grade Level',
            'field_specialty' => 'Delete Professional Specialization',
            'service' => 'Delete Service',

            // Scheduling
            'schedule' => 'Delete Schedule',
            'schedule_day' => 'Delete Schedule Day',
          'medical_exam' => 'Delete the Patient Medical Exam',
        ],

        /*
        |--------------------------------------------------------------------------
        | SCHEDULE ACTIONS
        |--------------------------------------------------------------------------
        */
        'schedule' => [

            'publish' => 'Publish Planning',
            'generate_days' => 'Generate Schedule Days',

            'generate_slots' => [

                "one" => "Generate Slots",
                "all" => "Generate Slots For All Days"
            ]

        ],



        "slot" => [
            "block" => "Block Slot",
            "unblock" => "Unblock Slot",
            "book" => "Book Appointment",
        ],
        /*
        |--------------------------------------------------------------------------
        | ROLES / PERMISSIONS ACTIONS
        |--------------------------------------------------------------------------
        */
        'roles' => [
            'detach' => [

                'coordinator' => 'Detach Coordinator',
                'appointments_location_agent' => 'Detach Appointments Location Agent',
                'doctor' => 'Detach Doctor',
                'medical_secretary' => 'Detach Medical Secretary',
            ],

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
        | DELETE CONFIRMATIONS
        |--------------------------------------------------------------------------
        */
        'delete' => [
            "file"=>'Are you sure you want to permanently delete the file ":attribute"?',
            "image"=>'Are you sure you want to permanently delete the image ":attribute"?',
            // Generic
            'user' => 'Are you sure you want to permanently delete the user ":attribute"?',
            'message' => 'Are you sure you want to permanently delete the message from ":attribute"?',
            'slider' => 'Are you sure you want to permanently delete the slider ":attribute"?',
            'slide' => 'Are you sure you want to permanently delete the slide ":attribute"?',

            // App structure
            'establishment' => 'Are you sure you want to permanently delete the establishment ":attribute"?',
            'wilaya' => 'Are you sure you want to permanently delete the state (code: :attribute)?',
            'daira' => 'Are you sure you want to permanently delete the district (code: :attribute)?',
            'commune' => 'Are you sure you want to permanently delete the municipality (code: :attribute)?',

            // Professional structure
            'field' => 'Are you sure you want to permanently delete the professional field ":attribute"?',
            'field_grade' => 'Are you sure you want to permanently delete the grade level ":attribute"?',
            'field_specialty' => 'Are you sure you want to permanently delete the professional specialization ":attribute"?',
            'service' => 'Are you sure you want to permanently delete the service ":attribute"?',

            // Scheduling
            'schedule' => 'Are you sure you want to permanently delete the schedule ":attribute"?',
            'schedule_day' => 'Are you sure you want to permanently delete the schedule day dated ":attribute"?',
            'medical_exam' => 'Are you sure you want to permanently delete the patient medical exam created on ":attribute"?',
        ],

        /*
        |--------------------------------------------------------------------------
        | SCHEDULE CONFIRMATIONS
        |--------------------------------------------------------------------------
        */
        'schedule' => [

            'publish' =>
            'Are you certain you want to publish the planning ":attribute"? After publication, only dates can be added; existing dates cannot be modified or deleted.',

            'generate_days' =>
            'You are about to generate calendar days for schedule ":attribute". After generation, working days, working periods, and days off cannot be modified. Do you wish to proceed?',

            'generate_slots' => [

                'one' =>
                'Are you sure you want to generate slots for ":attribute"? The selected day will be locked after generation.',

                'all' =>
                'Are you sure you want to generate slots for all days of schedule ":attribute"? Calendar days will be locked after generation and cannot be modified.',
            ],


        ],
        "slot" => [
            "block" => "Make this slot unavailable? Patients won't be able to book it.",
            "unblock" => "Make this slot available again? Patients can book it.",
            "book" => "Please confirm your appointment on :date at :start_at.",
        ],
        /*
        |--------------------------------------------------------------------------
        | ROLES CONFIRMATIONS
        |--------------------------------------------------------------------------
        */
        'roles' => [


            'detach' => [

                'coordinator' =>
                'Are you sure you want to detach the coordinator ":attribute"?',

                'appointments_location_agent' =>
                'Are you sure you want to detach the Appointments Location agent ":attribute"?',

                'doctor' =>
                'Are you sure you want to detach the doctor ":attribute"?',

                'medical_secretary' =>
                'Are you sure you want to detach the medical secretary ":attribute"?',
            ],
        ],

        /*
        |--------------------------------------------------------------------------
        | APPOINTMENT CONFIRMATIONS
        |--------------------------------------------------------------------------
        */
        'appointment' => [
            'cancel' => 'Confirm cancellation of your appointment on :date at :start_at?',
        ],
    ],
];
