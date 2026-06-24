<?php

return [
    'common' => [
        'actions' => [
            "confirm" => "Yes",
            "cancel" => "No",
            'submit' => 'Submit',
            'reset' => 'Reset Form',
        ],
        'errors' => [
            "default" => "An error occurred. Please contact your IT team.", // More professional and informative
            "not_match" => [
                'phone' => 'Phone number must start with 05, 06, or 07 and contain exactly 10 digits.',
                "land_line" => "The Landline Number must start with 0 and contain exactly 9 digits"
            ],
            'img' => [
                'not_img' => 'The file must be an image.',
                "not_imgs" => "The files must be images",
            ],
            'user' => [
                'not_exists' => 'The :attribute field is required.',
            ],
        ],
    ],

    "period" => [
        "start" => "Start Time",
        "end" => "End Time",
    ],
    "locations" => [
        "location" => "Appointment Location",
        "capacity" => "Available Doctors"
    ],
    'site_parameters' => [
        'steps' => [
            'first' => [
                'password' => 'Password',
                'email' => 'Your Email',
            ],
            'last' => [
                "maintenance" => "Maintenance Mode",
                'state' => "State",
                'enable' => "Enable",
                'disable' => "Disable",
            ],
        ],
        "actions" => [
            "download_db" => "Download Database"
        ],
        'responses' => [
            'you_can_pass' => 'You have the credentials to Update the App State', // Corrected grammar
            'success' => 'You have successfully updated the App State',
        ],
        'errors' => [
            'no_access' => "You don't have the necessary credentials for the next Step", // Corrected spelling
            'user_not_found' => 'Check your email and password and try again', // Corrected spelling
        ],
    ],

    'login' => [

        // Fields
        'login' => 'Email or Username',
        'email' => 'Email Address',
        'name' => 'Username',
        'password' => 'Password',

        'responses' => [
            'success' => 'You have been successfully logged in.',
        ],
        // Actions
        'actions' => [
            'submit' => 'Login',
        ],

        // Errors
        'errors' => [
            'invalid_credentials' => 'The provided credentials are incorrect.',
            'too_many_attempts' => 'Too many login attempts. Please try again later.',
        ],
    ],

'register' => [

    /*
    |--------------------------------------------------------------------------
    | INSTRUCTIONS
    |--------------------------------------------------------------------------
    */
    'instructions' => [
        'email_optional'=>"We recommend using a valid email address. You may need it for verification or account recovery.",
        'email' => 'Valid email required. A verification code will be sent to your email.',
        'code' => 'Enter the verification code sent to your email.',
        'password' => 'Minimum 8 characters required.',
        'name' => 'Enter your first and last name.',
        'terms' => 'You must agree to the platform rules before continuing.',
    ],

    /*
    |--------------------------------------------------------------------------
    | FIELDS
    |--------------------------------------------------------------------------
    */
    "name" => "Username",
    'first_name' => 'First Name',
    'last_name'  => 'Last Name',
    'email'      => 'Email Address',
    'password'   => 'Password',
    'code'       => 'Verification Code',
    'agree_terms' => 'I agree to the platform rules and terms',

    /*
    |--------------------------------------------------------------------------
    | ACTIONS
    |--------------------------------------------------------------------------
    */
    'actions' => [
        'get_code'     => 'Get Code',
        'get_new_code' => 'Resend Code',
        'submit'       => 'Create Account',
    ],

    /*
    |--------------------------------------------------------------------------
    | RESPONSES
    |--------------------------------------------------------------------------
    */
    'responses' => [
        'new_code' => 'New verification code sent to your email.',
        'success'  => 'Account created successfully.',
    ],

    /*
    |--------------------------------------------------------------------------
    | ERRORS
    |--------------------------------------------------------------------------
    */
    'errors' => [
        'verification_code'  => 'Invalid or expired verification code.',
        'too_many_attempts'  => 'Too many registration attempts. Please try again in a few minutes.',
    ],
],
    'forgot_password' => [
        'instructions' => [
            'email' => 'Enter your email to receive a verification code.',
            'code' => 'Enter the code sent to your email.',
        ],
        'email' => 'Email Address',
        'code' => 'Verification Code',
        'password' => 'New Password',
        'actions' => [
            'get_code' => 'Send Code',
        ],
        'responses' => [
            'new_code' => 'New verification code sent.',
            'success' => 'Password reset successfully.',
        ],
        'errors' => [
            'no_user' => 'No account found with this email address.',
            'verification_code' => 'Invalid or expired verification code.',
        ],
    ],
    'change_password' => [
        'infos' => [
            'redirect' => 'After changing your password, you will be logged out.',
        ],
        'old_pwd' => 'Your Old Password',
        'pwd' => 'Your New Password',
        'responses' => [
            'success' => 'The change was successful. You will be logged out now.', // Corrected spelling
        ],
        'errors' => [
            'old_pwd' => 'Please check your old password and try again.', // Improved error message
            'invalid_current' => "Password modification is restricted to Super Administrators and the account owner",
        ],
    ],
    'change_mail' => [
        'infos' => [
            'redirect' => 'You will be logged out after changing your email.', // More concise and natural
        ],
        'pwd' => 'Password',
        'mail' => 'Current Email', // More consistent capitalization
        'new_mail' => 'New Email',
        'responses' => [
            'success' => 'Your email has been successfully changed. You will now be logged out.', // More user-friendly
        ],
        'errors' => [
            'auth' => 'Please verify your current email and password and try again.', // More precise and professional
        ],
    ],
    'general_infos' => [
        'inaugural_year' => "Inaugural Year",
        'email' => "Email Address",
        'app_name' => "Application Name",
        'acronym' => "Institution Acronym",
        "address_fr" => "Official Address (French)",
        "address_en" => "Official Address (English)",
        "address_ar" => "Official Address (Arabic)",
        'logo' => "Institution Logo",
        'phone' => "Primary Phone",
        'landline' => "Landline Number",

        'fax' => "Fax Number",
        "theme_color" => "Theme Color",

        'map' => "Google Maps Location",
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
            'success' => 'Application general information has been successfully updated',
        ],
    ],
    'manage_hero' => [
        'title_ar' => "Title (AR)",
        'title_fr' => "Title (FR)",
        'title_en' => "Title (EN)",
        'sub_title_ar' => "Subtitle (AR)",
        'sub_title_fr' => "Subtitle (FR)",
        'sub_title_en' => "Subtitle (EN)",
        "introduction_fr" => "Introduction (FR)",
        "introduction_ar" => "Introduction (AR)",
        "introduction_en" => "Introduction (EN)",
        "primary_call_to_action_fr" => "Primary CTA (FR)",
        "primary_call_to_action_ar" => "Primary CTA (AR)",
        "primary_call_to_action_en" => "Primary CTA (EN)",
        "secondary_call_to_action_fr" => "Secondary CTA (FR)",
        "secondary_call_to_action_ar" => "Secondary CTA (AR)",
        "secondary_call_to_action_en" => "Secondary CTA (EN)",
        "images" => "Hero Images",
        'responses' => [
            'success' => 'Hero page content has been successfully updated',
        ],
    ],
    'manage_about_us' => [

        "sub_title_fr" => "sub_title (Fr)",
        "sub_title_ar" => "sub_title (Ar)",
        "sub_title_en" => "sub_title (En)",

        'first_paragraph_fr' => "First Paragraph (Fr)",
        'first_paragraph_ar' => "First Paragraph (Ar)",
        'first_paragraph_en' => "First Paragraph (En)",
        'second_paragraph_fr' => "Second Paragraph (Fr)",
        'second_paragraph_ar' => "Second Paragraph (Ar)",
        'second_paragraph_en' => "Second Paragraph (En)",
        'third_paragraph_fr' => "Third Paragraph (Fr)",
        'third_paragraph_ar' => "Third Paragraph (Ar)",
        'third_paragraph_en' => "Third Paragraph (En)",

        "image" => "About Us Section Image",

        'responses' => [
            'success' => 'You have successfully updated the AboutUs Page information of your App', // Corrected spelling
        ],

    ],
    'our_quality' => [

        'name_ar' => "Title in Arab",
        'name_fr' => "Title (Fr)",
        'name_en' => "Title (En)",
        "image" => "Image",
        'responses' => [
            'add_success' => 'You have successfully added a New Quality', // Corrected spelling
            'update_success' => 'You have successfully updated the selected Quality', // Corrected spelling
        ],

    ],


    "user" => [
        'instructions' => [
            "email" => "Valid email required. Verification code will be sent to this address.",
        ],
        'email' => "Email",
        "name" => "Username",
        'last_name' => "Last Name",
        "first_name" => "First Name",
        'is_active' => 'Account Status',
        "password" => "Password",
        "person_id" => "Personnel",
        "avatar" => "Avatar",

        "errors" => [
            'unique_super_admin' => "You can't deactivate this user because this is the last active super admin user.",
        ],
        'responses' => [
            "add_success" => "User account created successfully",
            "update_success" => "User account updated: :name",
        ],
    ],
    'role' => [
        'user_id' => "User Account",
        'roles' => "User Roles",
        'errors' => [
            'user_id_required' => 'User selection is required',
            'user_id_exists'   => 'The specified user account does not exist',
            'roles_required'   => 'At least one role must be selected',
            'roles_array'      => 'Roles must be provided as valid identifiers',
            'roles_exist'      => 'One or more specified roles are invalid',
            'user_not_found'   => 'The requested user account was not found',
            'unique_super_admin' => "You can't remove super admin role for this user because this is the last super admin user.",

            'error_title'      => 'Role Assignment Error',
        ],
        'responses' => [
            'success'      => 'User roles have been successfully updated',
            'own_success'  => 'Your roles have been updated. For security purposes, you have been logged out of all sessions.',
        ],
    ],



    "guest" => [
        "message" => [
            'name' => "Name",
            'name-placeholder' => "Your name",
            'email' => "Email",
            'email-placeholder' => "Your Email",
            "message" => "Message",
            'message-placeholder' => "Your Message",
            "sent" => "Send a message",
            'responses' => [
                'send_success' => 'Your message has been successfully sent. A reply will be sent to your email address',
            ],
        ]
    ],
    "reply" => [
        "message" => "Message",
        'responses' => [
            'send_success' => 'Your reply has been successfully sent to the visitor via email.',
        ],
    ],
    "slide" => [
        'title_fr' => "Title (Fr)",
        'title_ar' => "Title (Ar)",
        'title_en' => "Title (En)",
        "content_fr" => "Content (Fr)",
        "content_en" => "Content (En)",
        "content_ar" => "Content (Ar)",
        "order" => "Slide Order",
        "slider_id" => "Slider",
        'image' => "Image",
        'responses' => [
            'add_success' => 'You have successfully added a New Slide', // Corrected spelling
            'update_success' => 'You have successfully updated the selected Slide', // Corrected spelling
        ],
    ],
    "slider" => [
        "name" => "Slide Title",
        "position" => "Display Position",
        "user_id" => "Published By",
        'state' => "Publication Status",
        'responses' => [
            'add_success' => 'New slide has been successfully added',
            'update_success' => 'Selected slide has been successfully updated',
        ],
    ],
    'image' => [
        'display_name' => "Display Name",
        'use_case' => "Motive",
        'real_image' => "Image File",
        'responses' => [
            "add_success" => "Image File added successfully",
            'update_success' => "Image File has been updated successfully",
        ],
    ],
'file' => [
    'display_name' => "Display Name",
    'use_case' => "Motive",
    'real_file' => "PDF File",
    'responses' => [
        "add_success" => "File added successfully",
        'update_success' => "File has been updated successfully",
    ],
],

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// App
    "person" => [
        "last_name_fr" => "Last Name (FR)",
        "last_name_ar" => "Last Name (AR)",
        "first_name_fr" => "First Name (FR)",
        "first_name_ar" => "First Name (AR)",
        "profile_img" => "Profile Photo",
        'is_paid' => 'Payment Status',
        'is_active' => 'Account Status',
        "cv" => "CV Document",
        "email" => "Email",
        "card_number" => "National ID",
        "birth_date" => "Birth Date",
        'birth_place_fr' => "Birth Place (FR)",
        'birth_place_ar' => "Birth Place (AR)",
        "address_fr" => "Address (FR)",
        "address_ar" => "Address (AR)",
        "address_en" => "Address (EN)",
        'phone' => "Phone",
        "employee_number" => "Employee ID",
        "social_number" => "Social Security No.",
        'responses' => [
            "add_success" => "Personnel record created successfully",
            "update_success" => "Personnel record updated: :name",
        ],
    ],
    "wilaya" => [
        'designation_fr' => "French Name",
        'designation_ar' => "Arabic Name",
        'designation_en' => "English Name",
        'code' => "State Code",
        'responses' => [
            'add_success' => 'State created successfully',
            'update_success' => 'State updated successfully',
        ],
    ],
    "daira" => [
        'designation_fr' => "French Name",
        'designation_ar' => "Arabic Name",
        'designation_en' => "English Name",
        'code' => "District Code",  // Changed from "Diara Code"
        'responses' => [
            'add_success' => 'District created successfully',
            'update_success' => 'District updated successfully',
        ],
    ],
    "commune" => [
        'designation_fr' => "French Name",
        'designation_ar' => "Arabic Name",
        'designation_en' => "English Name",
        'code' => "Municipality Code",  // More formal than "Commune Code"
        'responses' => [
            'add_success' => 'Municipality created successfully',
            'update_success' => 'Municipality updated successfully',
        ],
    ],
    "field" => [
        'designation_fr' => "French Designation",
        'designation_ar' => "Arabic Designation",
        'designation_en' => "English Designation",
        'acronym' => "Acronym",
        'responses' => [
            'add_success' => 'Professional field created successfully',
            'update_success' => 'Field updated successfully',
        ],
    ],
    "field_grade" => [
        'designation_fr' => "French Designation",
        'designation_ar' => "Arabic Designation",
        'designation_en' => "English Designation",
        'acronym' => "Grade Code",
        'field_id' => "Professional Field",  // Fixed typo: 'filed_id' → 'field_id'
        'responses' => [
            'add_success' => 'Grade level created successfully',
            'update_success' => 'Grade level updated successfully',
        ],
    ],
    "field_specialty" => [
        'designation_fr' => "French Designation",
        'designation_ar' => "Arabic Designation",
        'designation_en' => "English Designation",
        'acronym' => "Specialty Code",
        'field_id' => "Professional Field",
        'responses' => [
            'add_success' => 'Professional specialty created successfully',
            'update_success' => 'Specialty updated successfully',
        ],
    ],
    "occupation" => [
        'field_id' => "Professional Field",
        'field_specialty_id' => "Area of Specialization",
        'field_grade_id' => "Professional Grade",
        "description_fr" => "Professional Description (French)",
        "description_en" => "Professional Description (English)",
        "description_ar" => "Professional Description (Arabic)",
        "experience" => "Years of Professional Experience",
        'errors' => [
            'field_required' => 'Professional field selection is required',
            'field_exists' => 'The selected professional field is invalid',
            'field_specialty_exists' => 'The selected specialization area is invalid',
            'field_grade_exists' => 'The selected professional grade is invalid',
        ],
        'responses' => [
            'add_success' => 'Professional occupation has been successfully added',
            'update_success' => 'Professional occupation has been successfully updated',
        ],
    ],

    'appointment' => [
        "patient_id" => "Patient",
        "schedule_day_id" => "Scheduled Day",
        'appointments_location_id' => "Appointment Location",
        "day_at" => "Appointment Date",
        "status" => "Appointment Status",
        "specialty_id"=>"Medical specialty",
        "referral_letter" => "Referral Letter (Image Format)",
        "referral_letter_short" => "Referral Letter",

        'information' => [
            'title' => 'To proceed with your appointment booking, please provide the following required information:',

            'specialty' => 'Please select a medical specialty for your consultation',

            'referral_letter' => 'A referral letter is required to complete your request',
        ],
        'responses' => [
            'add_success' => 'Appointment booked successfully.',
        ],

                'errors' => [
            'not_found' => [
                'patient' => 'Patient not found.',
                'schedule_slot' => 'Schedule slot not found.',
                'schedule_day' => 'Schedule day not found.',
                'specialty' => 'Specialty not found.',
            ],

            // --------------------
            // BUSINESS RULE ERRORS
            // --------------------

            'invalid_slot_day_match' => 'The selected time slot does not belong to the selected day.',

            'invalid_specialty_for_service' => 'The selected specialty does not match the service for this schedule.',

            // 🔥 IMPORTANT RULE ERROR YOU ASKED FOR
            'min_gap_days' => 'You must wait at least :days days before booking again. Your last appointment was on :last, and the selected date is :date.',
        ],
    ],
    'establishment' => [
        "acronym" => "Establishment Acronym",
        "name_fr" => "Establishment Name (French)",
        "name_ar" => "Establishment Name (Arabic)",
        "name_en" => "Establishment Name (English)",
        "email" => "Email Address",
        "address_fr" => "Complete Address (French)",
        "address_ar" => "Complete Address (Arabic)",
        "address_en" => "Complete Address (English)",
        "description_fr" => "Establishment Description (French)",
        "description_ar" => "Establishment Description (Arabic)",
        "description_en" => "Establishment Description (English)",
        "tel" => "Primary Phone Number",
        "fax" => "Fax Number",
        'capacity' => "Maximum Capacity",
        'daira_id' => "Administrative District",
        'longitude' => "Longitude",
        'latitude' => "Latitude",
        'responses' => [
            'add_success' => "New establishment has been registered successfully",
            'update_success' => "Establishment information has been updated successfully",
        ],
    ],
    'service' => [
        "name_fr" => "Service Name (French)",
        "name_ar" => "Service Name (Arabic)",
        "name_en" => "Service Name (English)",
        "specialty" => "Medical Specialty",
        "type" => "Service Type",
        "tel" => "Primary Phone",
        "fax" => "Fax",
        "head_of_service_id" => "Head of Service",
        "establishment_id" => "Affiliated Establishment",

        'responses' => [
            'add_success' => "Healthcare service created successfully",
            'update_success' => "Service updated successfully",
        ],
    ],
    'coordinator' => [
        'user_id' => 'Coordinator Name',
        'responses' => [
            'add_success' => 'Coordinator added successfully',
        ],
    ],
    'doctor' => [
        'user_id' => 'Doctor Name',
        'responses' => [
            'add_success' => 'Doctor added successfully',
        ],
    ],

    'medical_secretary' => [
        'user_id' => 'Medical Secretary Name',
        'responses' => [
            'add_success' => 'Medical secretary added successfully',
        ],
    ],
    "appointments_location_agent" => [
        "user_id" => "Employee Name",
        "appointments_location_id" => "Appointments Location",
        'responses' => [
            'add_success' => "Appointments location admin added successfully",
        ],
    ],

    'rating' => [
        'doctor_id' => "Doctor",
        'user_id' => "Patient",
        'rating' => "Rating (1-5)",
        'comment_fr' => "Feedback Comment (French)",
        'comment_ar' => "Feedback Comment (Arabic)",
        'comment_en' => "Feedback Comment (English)",

        'responses' => [
            'add_success' => "New rating has been submitted successfully",
            'update_success' => "Your rating has been updated successfully",
        ],
    ],
    'schedule' => [

        // =========================
        // INFORMATION (LOCK RULES)
        // =========================
        "information" => [
            "locked" => [

                "service_in_inactive_state" =>
                "This schedule is locked because the service is inactive.",

                "service_manager_only_own" =>
                "Service managers can only edit schedules they created.",

                "service_manager_only_published" =>
                "Service managers can only modify published schedules.",

                "coordinator_restriction" =>
                "You are not allowed to modify this schedule due to coordinator restrictions.",

                "default_only_draft" =>
                "This schedule is locked because only draft schedules can be edited.",

                "not_allowed_to_update" =>
                "You cannot update this schedule due to your role, service context, or schedule state.",
            ],
        ],

        // =========================
        // CORE FIELDS (FULLY COMPLETE)
        // =========================
        "year" => "Calendar Year",
        "month" => "Month",

        "name_fr" => "Schedule Name (Fr)",
        "name_en" => "Schedule Name (En)",
        "name_ar" => "Schedule Name (Ar)",

        "description_fr" => "Schedule Description (Fr)",
        "description_ar" => "Schedule Description (Ar)",
        "description_en" => "Schedule Description (En)",

        "state" => "Status",
        'appointment_duration'=>"Appointment Duration",

        "service_id" => "Medical Service",
        "opened_by" => "Created By",

        // =========================
        // WORKING RULES LABELS
        // =========================
        "working_days" => "Working Days",
        "days_off" => "Days Off",
        "working_periods" => "Working Periods",
        "appointments_locations" => "Appointment Locations",

        // =========================
        // RESPONSES
        // =========================
        "responses" => [
            "add_success" =>
            "New schedule has been created successfully.",

            "update_success" =>
            "Schedule has been updated successfully.",
        ],

        // =========================
        // ERRORS
        // =========================
        "errors" => [

            'multiple_location_selection' => 'You cannot select the same location more than once.',
            // -------------------------
            // WORKING PERIODS
            // -------------------------
            "working_periods" => [
                "start_required" =>
                "Item #:item_number: start time is required.",

                "end_required" =>
                "Item #:item_number: end time is required.",

                "invalid_time" =>
                "Item #:item_number has invalid time range.",

                "start_after_end" =>
                "Item #:item_number: start time must be before end time.",
            ],

            // -------------------------
            // APPOINTMENT LOCATIONS
            // -------------------------
            "locations" => [
                "location_required" =>
                "Item #:item_number: location is required.",

                "capacity_required" =>
                "Item #:item_number: capacity is required.",

                "capacity_min" =>
                "Item #:item_number: capacity must be at least 1.",

                "duplicate_location" =>
                "Item #:item_number: this location is already selected.",

                "invalid_location" =>
                "Item #:item_number: selected location is invalid.",
            ],

            // -------------------------
            // GENERAL VALIDATION
            // -------------------------
            "validation" => [
                "invalid_service" => "Selected service is invalid.",
                "invalid_year" => "Year is not valid.",
                "invalid_month" => "Month is not valid.",

                "working_days_required" => "At least one working day must be selected.",
            ],

            // -------------------------
            // NOT FOUND / BUSINESS RULES
            // -------------------------
            "not_found" => [
                "creator" =>
                "Service coordinator is required to create a schedule.",

                "service" =>
                "Service is required to create a schedule.",

                "schedule" =>
                "Schedule not found.",
            ],
        ],
    ],
'schedule_day' => [
    "state" => "Status",
    'appointment_duration' => "Appointment Duration",

    "day_at" => "Day at",

    "working_periods" => "Working Periods",
    "appointments_locations" => "Appointment Locations",

    // =========================
    // RESPONSES
    // =========================
    "responses" => [
        "add_success" =>
        "New schedule date has been created successfully.",

        "update_success" =>
        "Schedule date has been updated successfully.",
    ],
],

    'patient' => [

        'code' => 'Patient Code',

        'first_name_fr' => 'First Name (FR)',
        'first_name_ar' => 'First Name (AR)',

        'last_name_fr' => 'Last Name (FR)',
        'last_name_ar' => 'Last Name (AR)',

        'gender' => 'Gender',

        'birth_date' => 'Birth Date',

        'birth_place_fr' => 'Birth Place (FR)',
        'birth_place_ar' => 'Birth Place (AR)',
        'birth_place_en' => 'Birth Place (EN)',

        'address_fr' => 'Address (FR)',
        'address_ar' => 'Address (AR)',
        'address_en' => 'Address (EN)',

        'commune_id' => 'Commune',
        'daira' => 'Daira',

        'father_id' => 'Father',
        'mother_id' => 'Mother',

        'tel' => 'Phone Number',

        'insurance_number' => 'Insurance Number',

        'opened_by' => 'Created By',

        'responses' => [
            'add_success' => 'Patient created successfully.',
            'update_success' => 'Patient updated successfully.',
        ],
    ],

'medical_exam' => [
    'patient_id' => "Patient",
    'doctor_id' => "Physician",
    "specialty_id" => "Medical Specialty",
    'report_fr' => "Exam Report (FR)",
    'report_ar' => "Exam Report (AR)",
    'report_en' => "Exam Report (EN)",
    'responses' => [
        "add_success" => "Medical exam report added successfully.",
        'update_success' => "Medical exam report updated successfully.",
    ],
],

];
