<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumToArray;

enum GenderEnum: string
{
    use EnumToArray;

    case MALE = 'мужской';
    case FEMALE = 'женский';
    case ANY = 'любой';
}
