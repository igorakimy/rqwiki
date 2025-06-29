<?php

declare(strict_types=1);

namespace App\Enums;

enum PermissionsEnum: string
{
    case VIEW_ROLES = 'view_roles';
    case ASSIGN_ROLES = 'assign_roles';

    case VIEW_PERMISSIONS = 'view_permissions';
    case ASSIGN_PERMISSIONS = 'assign_permissions';

    case VIEW_USERS = 'view_users';
    case CREATE_USERS = 'create_users';
    case UPDATE_USERS = 'update_users';
    case DELETE_USERS = 'delete_users';
}
