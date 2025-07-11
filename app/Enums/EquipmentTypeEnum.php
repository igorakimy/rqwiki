<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumToArray;

enum EquipmentTypeEnum: string
{
    use EnumToArray;

    case EQUIPMENT = 'экипировка';
    case WEAPON = 'оружие';
}
