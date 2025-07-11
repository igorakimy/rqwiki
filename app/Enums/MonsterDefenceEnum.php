<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumToArray;

enum MonsterDefenceEnum: string
{
    use EnumToArray;

    case NO_DEF = 'Нет';
    case LOW = 'Низкая';
    case MIDDLE = 'Средняя';
    case HIGH = 'Высокая';
}
