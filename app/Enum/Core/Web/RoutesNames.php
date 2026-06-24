<?php

namespace App\Enum\Core\Web;

/**
 * Enum defining named routes for use across the application.
 * Using enums helps ensure consistency and avoids hardcoded strings.
 */
enum RoutesNames: string
{
    // Public & Guest Routes
    case INDEX = 'index';                         // Landing or homepage route
    case LOG_OUT = 'logout';                      // Logout route
    case IS_ON_MAINTENANCE_MODE = 'maintenanceMode'; // Check if the site is in maintenance
    case SITE_PARAMETERS = 'siteParameters';      // View or update general site parameters
    case SET_LANG = 'setLang';                    // Route for changing language


        // Authentication Routes
    case LOGIN = 'login';                         // Login page
    case REGISTER = 'register';                   // Registration page
    case FORGET_PASSWORD = 'forgetPassword';      // Forgot password route
    case DASHBOARD = 'dashboard';                  // Dashboard

        // User Routes
    case USER_ROUTE = 'home';                     // Default user dashboard/home
    case PROFILE = 'profile';                     // User profile page
    case CHANGE_PASSWORD = 'changePassword';      // Route to change user password
    case CHANGE_EMAIL = 'changeEmail';            // Route to change user email         // Route to change user email
    case TOGGLE_ACCOUNT_STATUS = 'ToggleActiveState';
    case PATIENT_ROUTE = "patient";

        // Super Admin Routes
    case SUPER_ADMIN_ROUTE = 'superAdminSpace';   // Super admin dashboard
    case OCCUPATION_FIELDS = 'occupationFields';
    case WILAYATES = 'wilayates';
    case WILAYA = 'WILAYA';



    case MESSAGES = 'messages';                   // View or manage contact messages
    case GENERAL_INFOS = 'generalInfos';          // General settings and info
    case MANAGE_MY_WORKS = 'myWorksScene';
    case MANAGE_HERO = 'heroScene';               // Hero section management
    case MANAGE_ABOUT_US = 'aboutUsScene';        // About Us section



        // Admin Routes

    case USERS_ROUTE = 'usersPage';            // Landing page management
    case ESTABLISHMENTS_ROUTE = "establishmentsRoute";
    case ESTABLISHMENT_ROUTE = "establishmentRoute";


        // establishment Admin Routes
    case ESTABLISHMENT_USERS_ROUTE = 'manageEstablishmentUsersRoute';            // Landing page management
    case ESTABLISHMENT_SERVICES_ROUTE = 'manageEstablishmentServicesRoute';            // Landing page management


        //service coordinator

    case MANAGE_SERVICE_ROUTE = 'manageServiceRoute';

        //medical secretary

    case MANAGE_SCHEDULES_ROUTE = "manageSchedules";
    case MANAGE_SCHEDULE_ROUTE = "manageSchedule";

        // appointments location agent

    case APPOINTMENTS_ROUTE = "appointmentsRoute";
    case MANAGE_PATIENTS_ROUTE = "managePatients";

        // Author Routes

    case SLIDERS_ROUTE = "sliders";               // Sliders management
    case SLIDER_ROUTE = "slides";                 // Slides management

    case DOCTOR_APPOINTMENTS_ROUTE = "doctorsAppointments";
    case MEDICAL_EXAMS_ROUTE = "medicalExams";
    case SERVICE_PATIENTS_ROUTE = "servicePatients";
}
