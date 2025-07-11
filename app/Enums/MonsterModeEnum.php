<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumToArray;

enum MonsterModeEnum: string
{
    use EnumToArray;

    case MELEE = 'Ближний бой';
    case RANGED = 'Дальний бой';
}
