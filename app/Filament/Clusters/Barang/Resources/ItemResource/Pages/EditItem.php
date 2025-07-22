<?php

namespace App\Filament\Clusters\Barang\Resources\ItemResource\Pages;

use App\Filament\Clusters\Barang\Resources\ItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditItem extends EditRecord
{
    protected static string $resource = ItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
