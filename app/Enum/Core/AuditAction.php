<?php

namespace App\Enum\Core;

enum AuditAction: string
{
    case CREATE = 'CREATE';
    case UPDATE = 'UPDATE';
    case DELETE = 'DELETE';
    case MOVE = 'MOVE';
    case RESERVE = 'RESERVE';
    case RELEASE = 'RELEASE';
    case ADJUST = 'ADJUST';

}
