<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumToArray;

enum EquipmentItemClassEnum: string
{
    use EnumToArray;

    case A = 'A';
    case B = 'B';
    case C = 'C';
}
