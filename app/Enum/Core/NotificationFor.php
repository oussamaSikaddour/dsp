<?php

namespace App\Enum\Core;

/**
 * Enum defining named routes for use across the application.
 * Using enums helps ensure consistency and avoids hardcoded strings.
 */
enum NotificationFor: string
{
  case USER   = 'user';
    case ADMIN  = 'admin';
    case STORE_MANAGER ="store_manager";
    case COMMANDS_DESTINATION_MANAGER ="commands_destination_manager";
    case COMMANDS_DESTINATION_APPROVER ="commands_destination_approver";

}
