<?php

namespace App\Filament\Clusters\Daerah\Resources\VillageResource\Pages;

use App\Filament\Clusters\Daerah\Resources\VillageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVillages extends ListRecords
{
    protected static string $resource = VillageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
