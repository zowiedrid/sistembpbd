<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class Barang extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationLabel = 'Barang'; //kustom nama label navigasi

    protected static ?string $slug = 'barang'; //kustom slug

    protected static ?string $modelLabel = 'Barang'; //kustom nama label model

    protected static ?string $navigationGroup = 'Manajemen Gudang'; //kustom nama grup navigasi

    protected static ?int $navigationSort = 1; //kustom urutan navigasi
}
