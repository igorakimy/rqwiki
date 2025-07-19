<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumToArray;

enum MediaCollectionEnum: string
{
    use EnumToArray;

    case DEFAULT = 'default';
    case WORLD_MAP = 'world_map';
    case LOCATIONS = 'locations';
    case NPC = 'npc';
    case MONSTERS = 'monsters';
    case RACES = 'races';
    case ELEMENTS = 'elements';
    case CARDS = 'cards';
    case WEAPONS = 'weapons';
    case EQUIPMENT = 'equipment';
    case EQUIPMENT_TYPE = 'equipment_type';
    case CHARACTER_CLASSES = 'character_classes';
    case LOOT = 'loot';
    case CURRENCIES = 'currencies';
    case OTHER = 'other';

    public function translate(): string
    {
        return match ($this) {
            self::DEFAULT => 'По умолчанию',
            self::WORLD_MAP => 'Карта мира',
            self::LOCATIONS => 'Локации',
            self::NPC => 'НПС',
            self::MONSTERS =>'Монстры',
            self::RACES => 'Расы',
            self::ELEMENTS =>'Элементы',
            self::CARDS => 'Карты',
            self::WEAPONS =>'Оружие',
            self::EQUIPMENT => 'Экипировка',
            self::EQUIPMENT_TYPE =>'Типы экипировки',
            self::CHARACTER_CLASSES => 'Классы персонажей',
            self::LOOT =>'Трофеи',
            self::CURRENCIES => 'Валюты',
            self::OTHER =>'Другое',
        };
    }

    public static function translatedValues(): array
    {
        $translations = [];

        foreach (self::cases() as $case) {
            $translations[] = $case->translate();
        }

        return $translations;
    }
}
