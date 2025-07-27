<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumToArray;

enum MonsterDefenceEnum: string
{
    use EnumToArray;

    case NO_DEF = 'нет';
    case LOW = 'низкая';
    case MIDDLE = 'средняя';
    case HIGH = 'высокая';
}
