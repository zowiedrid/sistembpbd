<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class Daerah extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-building-library';

    protected static ?string $slug = 'daerah'; //kustom slug

    protected static ?string $navigationLabel = 'Daerah'; //kustom nama label navigasi

    protected static ?string $modelLabel = 'Daerah'; //kustom nama label model

    protected static ?string $navigationGroup = 'Manajemen Sistem'; //kustom nama grup navigasi

    protected static ?int $navigationSort = 1; //kustom urutan navigasi
}
