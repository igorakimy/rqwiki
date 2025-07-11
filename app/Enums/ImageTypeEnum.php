<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumToArray;

enum ImageTypeEnum: string
{
    use EnumToArray;

    case IMAGE = 'изображение';
    case ICON = 'иконка';
}
