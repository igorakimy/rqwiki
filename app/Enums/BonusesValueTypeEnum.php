<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumToArray;

enum BonusesValueTypeEnum: string
{
    use EnumToArray;

    case ACTUAL = 'фактическое';
    case PERCENT = 'процент';
}
