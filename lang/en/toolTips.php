<?php
return [
    "common" => [
        "filters" => "Open Filters",
        "resetFilters" => "Reset Filters",
        "resetForm" => "Reset Form",
        "add" => "Add New",
        "update" => "Update",
        'per_page' => "Par page",
        "previous" => [
            "page" => "Previous Page" // Corrected spelling of "pervious"
        ],
        "manage" => [
            "sliders" => "Manage Sliders",
            "articles" => "Manage Articles",
        ],
    ],

    'image' => [
        "delete" => "Delete Image",
        "update" => "Update Image",
    ],
    'file' => [
        "delete" => "Delete File",
        "update" => "Update File",
    ],

    "user" => [
        "delete" => "Delete This User",
        "update" => "Update This User",
        "manage" => [
            "roles" => "Manage User's Roles",
            "occupations" => "Manage User's Occupations",
            "banking_information" => "Manage User's Banking Information",
            'users' => "Insert Staff"
        ],
        "excel" => [
            "empty" => "generate Empty Users 's Excel File",
            "download" => "Export Users's Excel File",
            "upload" => "Import Users's Excel File",
        ]
    ],


    "message" => [
        "delete" => "Delete This Message",
        "reply" => "Reply to This Message"
    ],

    "slider" => [
        "delete" => "Delete This Slider",
        "update" => "Update This Slider",
        'manage' => "Add Slides"
    ],

    "slide" => [
        "delete" => "Delete This Slide",
        "update" => "Update This Slide"
    ],

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// App


    "person" => [
        "delete" => "Delete Personnel",
        "update" => "Edit Personnel",
        "manage" => [
            "account" => "Manage Account",
            "occupations" => "Manage Occupations",
            "banking_information" => "Manage Banking",
            'persons' => "Add Staff"
        ],
        "excel" => [
            "empty" => "Download Template",
            "download" => "Export to Excel",
            "upload" => "Import from Excel",
        ]
    ],


    "wilaya" => [
        "delete" => "Delete State",
        "update" => "Update State",
        "manage" => [
            "view" => "View State Details",
        ],
        "excel" => [
            "empty" => "Download Template",
            "download" => "Export State Data",
            "upload" => "Import State Data"
        ]
    ],

    "daira" => [
        "delete" => "Delete District",
        "update" => "Update District",
        "manage" => [
            "communes" => "Manage Municipalities",
        ],
        "excel" => [
            "empty" => "Download Template",
            "download" => "Export District Data",
            "upload" => "Import District Data"
        ]
    ],

    "commune" => [
        "delete" => "Delete Municipality",
        "update" => "Update Municipality",
        "excel" => [
            "empty" => "Download Template",
            "download" => "Export Municipality Data",
            "upload" => "Import Municipality Data"
        ]
    ],

    "field" => [
        "delete" => "Delete Field",
        "update" => "Update Field",
        "manage" => [
            "specialties" => "Manage Field Specialties",
            "grades" => "Manage Grade Levels",
            'fields' => "Assign Fields"
        ],
        "excel" => [
            "empty" => "Download Template",
            "download" => "Export Field Data",
            "upload" => "Import Field Data"
        ]
    ],

    "field_grade" => [
        "delete" => "Delete Grade Level",
        "update" => "Update Grade Level",
        "manage" => [
            'fields' => "Assign Professional Fields"
        ],
        "excel" => [
            "empty" => "Download Template",
            "download" => "Export Grade Data",
            "upload" => "Import Grade Data"
        ]
    ],

    "field_specialty" => [
        "delete" => "Delete Specialization",
        "update" => "Update Specialization",
        "manage" => [
            'fields' => "Assign Professional Specializations"
        ],
        "excel" => [
            "empty" => "Download Template",
            "download" => "Export Specialization Data",
            "upload" => "Import Specialization Data"
        ]
    ],

    "occupation" => [
        "delete" => "Delete This Occupation",
        "update" => "Update This Occupation"
    ],




    'establishment' => [
        "delete" => "Delete Establishment",
        "update" => "Update Establishment",
        "map" => "View Establishment on Google Maps",
        "manage" => [
            "view" => "View Establishment Details",
            "bulk_insert" => "Bulk Import Establishments"
        ],
        "excel" => [
            "empty" => "Download Empty Template",
            "download" => "Export Establishment Data",
            "upload" => "Import Establishment Data"
        ]
    ],
    'service' => [
        "delete" => "Delete Service",
        "update" => "Update Service",
        "manage" => [
            "view" => "View Service Details",
            "bulk_insert" => "Bulk Import Services",
            "coordinators" => "Manage Coordinators",
        ],
        "excel" => [
            "empty" => "Download Template",
            "download" => "Export Service Data",
            "upload" => "Import Service Data"
        ]
    ],

    "establishment-admin" => [
        "ban" => "Remove role as coordinator",
    ],

    'coordinator' => [
        "detach" => [
            "doctor" => "Detach Doctor",
            "medical_secretary" => "Detach Medical Secretary"
        ]
    ],
    'appointments-location-admin' => [
        "ban" => "Remove role as Appointments Location Admin",
    ],
    'schedule' => [
        "delete" => "Delete Schedule",
        "update" => "Edit Schedule",
        "publish" => "Publish Schedule",
        "manage" => [
            "view" => "View Schedule Details",
            "generate" => "Generate Schedule Days"
        ],
    ],
    'schedule_day' => [
        "delete" => "Delete Planning Date",
        "update" => "Update Planning Date",
        "view" => "View Slots",
        "generate" => [
            "for_one" => "Generate Slots",
            "for_all" => "Generate Slot for all days"
        ]
    ],
    'schedule_day' => [
        "delete" => "Delete Planning Date",
        "update" => "Update Planning Date",
        "view" => "View Slots",
        "generate" => [
            "for_one" => "Generate Slots",
            "for_all" => "Generate Slot for all days"
        ]
    ],
    'schedule_slot' => [
        "block" => "Block This Slot",
        "unblock" => "Unlock This Slot",
        "book" => "Book This Appointment Slot",
        "options" => [
            "expand" => "expand booking criteria",
            "reset" => "reset to default",
        ]
    ],
'appointment' => [
    "cancel" => "Cancel Appointment",
    "get_confirmation" => "Download Confirmation Document",
    "location" => "Appointment Location Map",
    'referral_letter' => "View Referral Letter",
    "export" => "Download :date's Appointments List",
    'follow-up' => "Book a Follow-up"
],
'patient' => [
    "delete" => [
        "relative" => "Remove My Relative",
        "patient" => "Remove The Patient",
    ],
    "update" => [
        "relative" => "Update My Relative Info",
        "patient" => "Update Patient Info"
    ],
"view" => [
    "exam" => "Patient Exams List",
    "relative" => "Manage My Relative's Appointments",
    "patient" => "Manage the Patient's Appointments"
],
    "print_opened_by" => 'Print The Account Info',

],
'medical_exam' => [
    "delete" => "Delete The Medical Exam",
    "update" => "Update the Medical Exam",
    "manage" => [
        "images" => "Manage The Medical Exam Documents (Image Format)",
        "files" => "Manage The Medical Exam Documents (PDF Format)",
    ],
],

];
