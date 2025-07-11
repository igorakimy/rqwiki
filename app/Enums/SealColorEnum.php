<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumToArray;

enum SealColorEnum: string
{
    use EnumToArray;

    case GREEN = 'зелёный';
    case BLUE = 'синий';
    case VIOLET = 'фиолетовый';
    case ORANGE = 'оранжевый';
}
