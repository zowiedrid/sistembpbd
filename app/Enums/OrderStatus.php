<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum OrderStatus: string implements HasColor, HasIcon, HasLabel
{
    case Baru = 'baru';

    case Ditinjau = 'ditinjau';

    case Dikirim = 'dikirim';

    case Selesai = 'selesai';

    case Dibatalkan = 'dibatalkan';

    public function getLabel(): string
    {
        return match ($this) {
            self::Baru => 'Baru',
            self::Ditinjau => 'Ditinjau',
            self::Dikirim => 'Dikirim',
            self::Selesai => 'Selesai',
            self::Dibatalkan => 'Dibatalkan',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Baru => 'info',
            self::Ditinjau => 'warning',
            self::Dikirim, self::Selesai => 'success',
            self::Dibatalkan => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Baru => 'heroicon-m-sparkles',
            self::Ditinjau => 'heroicon-m-arrow-path',
            self::Dikirim => 'heroicon-m-truck',
            self::Selesai => 'heroicon-m-check-badge',
            self::Dibatalkan => 'heroicon-m-x-circle',
        };
    }
}
