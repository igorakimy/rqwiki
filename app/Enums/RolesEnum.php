<?php

declare(strict_types=1);

namespace App\Enums;

enum RolesEnum: string
{
    case SUPER_ADMIN = 'super-admin';
    case ADMIN = 'admin';
    case EDITOR = 'editor';
    case MODERATOR = 'moderator';
    case PLAYER = 'player';
}
