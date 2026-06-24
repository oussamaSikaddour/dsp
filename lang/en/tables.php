<?php
return [
    "common" => [
        "excel-file-type-err" => "The file must be in Excel format (XLSX, XLS, CSV)",
        "actions" => "Actions",
        "perPage" => "Per Page"
    ],


    'images' => [
        "info" => "images files list",
        "not_found" => "No Images Files found",
        'display_name' => "Display Name",
        "use_case" => "Use Case",
        'created_at' => "Added At",
        'preview' => "Preview",
    ],
    'files' => [
        "info" => "Pdfs files list",
        "not_found" => "No Pdfs Files found",
        'display_name' => "Display Name",
        "use_case" => "Use Case",
        'created_at' => "Added At",
        'preview' => "Preview",
        "download" => "Download File"
    ],

    'users' => [
        "info" => 'User Registry',

        "not_found" => "No users available",
        "name" => "Username",
        "last_name" => "Last Name",
        "first_name" => "First Name",
        "fullName" => "Name",
        "email" => "Email Address",
        "avatar" => "Profile",
        "registration_date" => "Account created on",

        "excel" => [
            "upload" => [
                "success" => "Users imported successfully"
            ]
        ]
    ],

    'messages' => [
        'info' => 'Visitors\' Messages',
        'not_found' => 'No visitors\' messages found at the moment', // Improved wording and possessive
        'name' => 'Name', // More concise
        'email' => 'Email',
        'created_at' => 'Received Date',
    ],

    'sliders' => [
        "info" => "Sliders List",
        "not_found" => "No Sliders Found",
        "created_at" => "Added At",
        'creator' => "Creator",
        'name' => "Name",
        "position" => "Position",
        "location" => "Location",
        "state" => "Status",
    ],
    "slides" => [
        "info" => "Slider List",
        "not_found" => "No Slider Fond at the moment",
        "created_at" => "Added At",
        'title' => "Title",
        'order' => 'Order',
        'image' => "Image",
        "location" => "Location",
        "state" => "State",
    ],
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// App


    'persons' => [
        "info" => "Personnel Registry",
        "empty" =>  "No personnel records found",
        "full_name" => "Full Name",
        "full_name_fr" => "Full Name (FR)",
        "full_name_ar" => "Full Name (AR)",
        "employee_number" => "Employee ID",
        "social_number" => "Social Security No.",
        "email" => "Official Email",
        "registration_date" => "Registration Date",
        "phone" => "Phone",
        "card_number" => "National ID",
        "bank_acronym" => "Bank",
        "bank_account" => "Bank Account",
        "birth_date" => "Birth Date",
        "birth_place_fr" => "Birth Place (FR)",
        "birth_place_ar" => "Birth Place (AR)",
        "birth_place_en" => "Birth Place (EN)",
        "excel" => [
            "upload" => [
                "success" => "Personnel records imported successfully"
            ]
        ]
    ],
    'wilayates' => [
        "info" => "Wilayates List",
        "not_found" => "No Wilayates Fond at the moment",
        "code" => "code",
        "designation" => "Designation",
        "designation_fr" => "Designation (French)",
        "designation_ar" => "Designation (Arabic)",
        "designation_en" => "Designation (English)",
        "registration_date" => "Registration Date",
        "excel" => [
            "upload" => [
                "success" => "Wilayates list uploaded successfully"
            ]
        ]
    ],
    'wilayates' => [
        "info" => "States Directory",
        "not_found" => "No states currently available",
        "code" => "State Code",
        "designation" => "State Name",
        "designation_fr" => "French Name",
        "designation_ar" => "Arabic Name",
        "designation_en" => "English Name",
        "registration_date" => "Registration Date",
        "excel" => [
            "upload" => [
                "success" => "States data imported successfully"
            ]
        ]
    ],
    'dairates' => [
        "info" => ":name 's Districts ",
        "not_found" => "No districts currently available",
        "code" => "District Code",
        "designation" => "District Name",
        "designation_fr" => "French Name",
        "designation_ar" => "Arabic Name",
        "designation_en" => "English Name",
        "registration_date" => "Registration Date",
        "excel" => [
            "upload" => [
                "success" => "Districts data imported successfully"
            ]
        ]
    ],
    'communes' => [
        "info" => ":name 's communes ",
        "not_found" => "No communes currently available",
        "code" => "commune Code",
        "designation" => "commune Name",
        "designation_fr" => "French Name",
        "designation_ar" => "Arabic Name",
        "designation_en" => "English Name",
        "registration_date" => "Registration Date",
        "excel" => [
            "upload" => [
                "success" => "communes data imported successfully"
            ]
        ]
    ],
    'fields' => [
        "info" => "Fields List",
        "not_found" => "No Fields Fond at the moment",
        "acronym" => "Acronym",
        "designation" => "Designation",
        "designation_fr" => "Designation (French)",
        "designation_ar" => "Designation (Arabic)",
        "designation_en" => "Designation (English)",
        "registration_date" => "Registration Date",
        "excel" => [
            "upload" => [
                "success" => "Fields list uploaded successfully"
            ]
        ]
    ],
    'field_grades' => [
        "info" => "Grade Levels for Field: :acronym",
        "not_found" => "No grade levels currently available",
        "acronym" => "Grade Code",
        "designation" => "Grade Title",
        "designation_fr" => "French Title",
        "designation_ar" => "Arabic Title",
        "designation_en" => "English Title",
        "registration_date" => "Registration Date",
        "excel" => [
            "upload" => [
                "success" => "Grade levels imported successfully"
            ]
        ]
    ],
    'field_specialties' => [
        "info" => "Professional Specialties: :acronym",
        "not_found" => "No specialties currently available",
        "acronym" => "Specialty Code",
        "designation" => "Specialization Title",
        "designation_fr" => "French Title",
        "designation_ar" => "Arabic Title",
        "designation_en" => "English Title",
        "registration_date" => "Registration Date",
        "excel" => [
            "upload" => [
                "success" => "Specializations imported successfully"
            ]
        ]
    ],

    'occupations' => [
        "info" => "Occupations List",
        "info_custom" => ":name 's Occupations List",
        "not_found" => "No Occupations Fond at the moment",
        "is_active" => "State",
        "entitled" => "Entitled",
        "field" => "Field",
        "experience" => "Experience",
        "specialty" => "Specialty",
        "grade" => "Grade",
        "created_at" => "Added At",
    ],


    'establishments' => [
        "info" => "Establishments List",
        "empty" => "No establishments available",
        "not_found" => "No establishments found",

        "acronym" => "Acronym",
        "name" => "Name",
        "name_fr" => "French Name",
        "name_ar" => "Arabic Name",
        "name_en" => "English Name",

        "email" => "Email",
        "tel" => "Phone",
        "fax" => "Fax",
        "daira" => "Daira",
        "created_at" => "Created at",

        "longitude" => "Longitude",
        "latitude" => "Latitude",

        "excel" => [
            "upload" => [
                "success" => "Establishments imported successfully"
            ]
        ],

        "success" => [
            "delete" => "Establishment deleted successfully",
            "update" => "Establishment updated successfully",
            "create" => "Establishment created successfully",
        ],

        "errors" => [
            "default" => "Something went wrong, please try again",
            "not_found" => [
                "establishment" => "Establishment not found",
            ],
        ],
    ],

    'services' => [
        "info" => "Services List for Establishment",
        "not_found" => "No services currently registered",
        "created_at" => "Registration Date",
        "name" => "Service Name",
        "name_fr" => "Service Name (French)",
        "name_en" => "Service Name (English)",
        "name_ar" => "Service Name (Arabic)",
        "tel" => "Primary Phone",
        "fax" => "Fax",
        "head_service" => "Head of Service",
        "establishment" => "Parent Establishment",
        "type" => "Service Type",
        "specialty" => "Medical Specialty",
        "excel" => [
            "upload" => [
                "success" => "Services imported successfully"
            ]
        ]
    ],
    'coordinators' => [
        "name" => "Name",
        "email" => "Official Email",
        'not_found' => "No Coordinators Found"
    ],
    "appointments_location_admins" => [
        "name" => "Name",
        "email" => "Official Email",
        'not_found' => "No Appointments locations agent found"
    ],
    "appointments_locations_agents" => [
        "name" => "Name",
        'location' => "Appointments location",
        "email" => "Official Email",
        'not_found' => "No Appointments locations agents found"
    ],

    'doctors' => [
        'name' => 'Name',
        'email' => 'Email',
        'not_found' => 'No doctors found',
    ],

    'medical_secretaries' => [
        'name' => 'Name',
        'email' => 'Email',
        'not_found' => 'No medical secretaries found',
    ],
    "available_appointments" => [
        "info" => [
            "follow-ups" => "Follow-up Appointments for Patient: :code",
            "initials" => "Available Appointments - Please Select Preferred Date",
        ],
        "not_found" => "No appointments currently available. Please verify form entries or check again later",
        "date_at" => "Appointment Date",
        "daira" => "District",
        "doctor" => "Assigned Physician",
        "appointments_location" => "Appointment Venue",
    ],
    "confirmed_appointments" => [
        "info" => "Confirmed Appointments",
        "not_found" => "No appointments currently available. Please verify filter entries or check again later",
        "queue_number" => "Queue Number",
        "patient" => "Patient Name",
        "patient_code" => "Patient Code",
        "patient_birth_date" => "Birth Date",
        "patient_tel" => "Phone",
        "year" => "Year",
        "month" => "Month",
        "specialty" => "Specialty",
        "doctor" => "Doctor",
        "doctor_name" => "Doctor",
        'daira' => "District",
        "location" => "Appointment Location",
        "schedule_day" => "Appointment Date",
        "date" => "Appointment Date",
        "type" => "Type",
        "referral_letter" => "Referral Letter"
    ],
    "patient_visits" => [
        "info" => "Patient Visits Reports List",
        "not_found" => "No Patient Visits Reports available. Please verify filter entries or check again later",
        "patient" => "Patient Name",
        "patient_code" => "Patient Code",
        'doctor' => "Doctor",
        "created_at" => "Creation Date",

    ],
    'medical_files' => [
        "info" => "My relatives medical files",
        "not_found" => "No medical files available yet",
        "code" => "Code",
        'name' => "Name",
        'year' => "Year",
        "last_name_fr" => "Last Name (Fr)",
        "last_name_ar" => "Last Name (Ar)",
        "first_name_fr" => "First Name (Fr)",
        "first_name_ar" => "First Name (Ar)",
        "insurance_number" => "Insurance Number",
        'gender' => "Gender",
        "birth_date" => "Date of Birth",
        "tel" => "Phone Number",
        'created_at' => "Record Creation Date"
    ],

    'ratings' => [
        "info" => "Patient Ratings for Dr. :doctor",
        "not_found" => "No patient ratings available yet",
        'doctor' => "Physician",
        'user_id' => "Patient",
        'rating' => "Patient Satisfaction Score (1-5)",
        'created_at' => "Rating Date"
    ],
    'schedules' => [
        "info" => "Services Schedules List",
        "not_found" => "No schedule found",

        "year" => "Year",
        "month" => "Month",
        "name" => "Designation",
        "name_fr" => "Designation (Fr)",
        "name_en" => "Designation (En)",
        "name_ar" => "Designation (Ar)",

        "state" => "Publication Status",
        "created_at" => "Creation Date",
        "service" => "Medical Service",
        "created_by" => "Created By",

        "errors" => [
            "no_days_found" => "This schedule has no generated days. Please generate days first.",
            "missing_slots" => "One or more schedule days have no time slots.",
            "slot_not_found" => "Some schedule slots are missing or not generated properly.",
            "invalid_booking_data" => "Invalid booking data provided.",
        ],
        "success" => [
            "generate" => "You have successfully generated the schedule :name's days."
        ]
    ],
    'schedule_days' => [
        "info" => "Schedule Days List",
        "not_found" => "No schedule day found",

        "day_at" => "Date",
        "schedule" => "Schedule",
        "specialty" => "Specialty",
        "slots" => "Number of Slots",

        "appointment_duration" => "Appointment Duration",
        "working_periods" => "Working Periods",
        "appointments_locations" => "Appointments Locations",

        "locked" => "Locked Status",
        "created_at" => "Creation Date",

        "errors" => [
            "no_days_found" => "No schedule days were found for this schedule.",
            "missing_periods_or_locations" => "This schedule day is missing working periods or appointment locations.",
            "locked" => "This schedule day is locked and cannot be modified.",
            "published" => "This schedule is already published and cannot be modified.",
            "invalid_generation" => "Unable to generate schedule day data.",
            "missing_slots" => "This schedule day has no generated slots.",
            "slot_generation_failed" => "Failed to generate time slots for this schedule day.",
        ],

        'success' => [
            'slots_for_all' => 'Slots generated successfully for all schedule days.',
            'slot_for_one' => 'Slots generated successfully.',
        ],
    ],

    'schedule_slots' => [
        "info" => "Schedule Slots List of the date :date",
        "not_found" => "No schedule slot found",
        "day_at" => "Date",
        "start_at" => "Start Time",
        "end_at" => "End Time",
        "duration" => "Duration",
        "status" => "Slot Status",
        "status_available" => "Available",
        "status_booked" => "Booked",
        "status_blocked" => "Blocked",

        "schedule_day" => "Schedule Day",
        "specialty" => "Specialty",
        "appointments_location" => "Appointments Location",

        "daira" => "District",

        "created_at" => "Creation Date",

        "errors" => [
            "not_found" => "This schedule slot was not found.",
            "already_booked" => "This slot is already booked and cannot be modified.",
            "blocked" => "This slot is blocked and cannot be used.",
            "invalid_time_range" => "Invalid time range for this slot.",
            "overlap" => "This slot overlaps with an existing one.",
            "generation_failed" => "Failed to generate schedule slots.",
            "missing_schedule_day" => "This slot has no related schedule day.",
        ],

        "success" => [
            "blocked" => "Slot blocked successfully.",
            "unblocked" => "Slot unblocked successfully.",
            "generated" => "Slots generated successfully.",
            "updated" => "Slot updated successfully.",
        ],
    ],

    "patients" => [
        "info" => [
            "relatives" => "Relatives's List",
            "patients" => "Patients' List",
        ],
        "not_found" => [
            "relatives" => "No Relatives found at the moment",
            "patients" => "No Patients found at the moment"
        ],
        "code" => "Patient Code",
        "name" => "Full Name",
        "gender" => "Gender",
        "full_name" => "Full Name",
        "tel" => "Phone Number",
        "birth_date" => "Birth Date",
        "commune" => "Commune",
        "appointments" => "Appointments' Number"
    ],
    'visits' => [
        "info" => "Patient Visit Records",
        "not_found" => "No visit records found",
        'appointment' => "Appointment Reference",
        "code" => "Patient ID",
        'patient' => "Patient Name",
        'doctor' => "Attending Physician",
        "date" => "Consultation Date"
    ],


    'appointments' => [
        'info' => [
            "relative" => ":name appointments",
            'patients' => "Patients appointments"
        ],
        'not_found' => 'no appointments found at the moment',
        'year' => 'Year',
        'month' => 'Month',
        'patient' => 'Patient',
        'code' => 'Code',
        'specialty' => 'Specialty',
        'service' => 'Service',
        'daira' => 'Daira',
        'location' => 'Appointments Location',
        'date' => 'Date',
        'start_at' => 'Start Time',
        'type' => 'Type',
        // Excel / export headers
        'queue' => 'Queue',

        'errors' => [
            "cannot_cancel_less_than_3_days" => 'Appointments cannot be cancelled less than 3 days before the scheduled date',
            "missing_coordinates" => "Appointment location are missing"
        ],
        "success" => [
            "cancel" => "You have succecfuly canceled you appopinmtnt ,"
        ]
    ],
    'medical_exams' => [
        'info' => 'medical exams history',
        'not_found' => 'no medical exams history found at the moment',
        'patient' => 'Patient Name',
        'patient_code' => 'Patient Code',
        "patient_tel" => "Patient Phone",
        "created_at" => "Exam Date",
        'specialty' => "Exam specialty",
        'doctor' => "Doctor",
    ],

];
