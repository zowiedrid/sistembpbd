<?php

namespace App\Filament\Clusters\Daerah\Resources\DistrictResource\Pages;

use App\Filament\Clusters\Daerah\Resources\DistrictResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDistricts extends ListRecords
{
    protected static string $resource = DistrictResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
