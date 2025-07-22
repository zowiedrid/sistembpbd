<?php

namespace App\Filament\Clusters\Barang\Resources\ItemResource\Pages;

use App\Filament\Clusters\Barang\Resources\ItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListItems extends ListRecords
{
    protected static string $resource = ItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
