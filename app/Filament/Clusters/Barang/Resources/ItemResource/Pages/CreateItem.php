<?php

namespace App\Filament\Clusters\Barang\Resources\ItemResource\Pages;

use App\Filament\Clusters\Barang\Resources\ItemResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateItem extends CreateRecord
{
    protected static string $resource = ItemResource::class;
}
