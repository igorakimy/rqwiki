<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumToArray;

enum QuestInteractionTypeEnum: string
{
    use EnumToArray;

    case BRING = 'принести';
    case TAKE = 'отнести';
    case KILL = 'убить';
}
