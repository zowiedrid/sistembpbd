<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum UnitItem: string implements HasColor, HasIcon, HasLabel
{
    case PCS = 'pcs';
    case KG = 'kg';
    case GRAM = 'gram';
    case LITER = 'liter';
    case LUSIN = 'lusin';
    case SATUAN = 'satuan';

    public function getLabel(): string
    {
        return match ($this) {
            self::PCS => 'Pcs',
            self::KG => 'Kg',
            self::GRAM => 'Gram',
            self::LITER => 'Liter',
            self::LUSIN => 'Lusin',
        };
    }

    public function getColor(): string | array | null
    {
        // Example colors, adjust as needed
        return match ($this) {
            self::PCS, self::LUSIN, self::PCS => 'info',
            self::KG, self::GRAM => 'success',
            self::LITER => 'warning',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::PCS => 'heroicon-m-cube',
            self::KG => 'heroicon-m-scale',
            self::GRAM => 'heroicon-m-calculator',
            self::LITER => 'heroicon-m-beaker',
            self::LUSIN => 'heroicon-m-archive',
        };
    }
}
