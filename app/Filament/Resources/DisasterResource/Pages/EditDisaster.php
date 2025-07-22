<?php

namespace App\Filament\Resources\DisasterResource\Pages;

use App\Filament\Resources\DisasterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDisaster extends EditRecord
{
    protected static string $resource = DisasterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
