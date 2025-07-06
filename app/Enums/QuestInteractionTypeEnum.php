<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumToArray;

enum QuestInteractionTypeEnum: string
{
    use EnumToArray;

    case BRING = 'Принести';
    case TAKE = 'Отнести';
    case KILL = 'Убить';
}
