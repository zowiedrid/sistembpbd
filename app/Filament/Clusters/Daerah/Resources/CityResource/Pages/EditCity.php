<?php

namespace App\Filament\Clusters\Daerah\Resources\CityResource\Pages;

use App\Filament\Clusters\Daerah\Resources\CityResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCity extends EditRecord
{
    protected static string $resource = CityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
