<?php

namespace App\Filament\Clusters\Barang\Resources\BrandResource\Pages;

use App\Filament\Clusters\Barang\Resources\BrandResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBrand extends EditRecord
{
    protected static string $resource = BrandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
