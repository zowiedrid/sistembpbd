<?php

namespace App\Filament\Clusters\Daerah\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use App\Filament\Clusters\Daerah;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Laravolt\Indonesia\Models\District;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Clusters\Daerah\Resources\DistrictResource\Pages;
use App\Filament\Clusters\Daerah\Resources\DistrictResource\RelationManagers;

class DistrictResource extends Resource
{
    protected static ?string $model = District::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $cluster = Daerah::class;

    protected static ?string $navigationLabel = 'Kecamatan'; //kustom nama label navigasi

    protected static ?string $modelLabel = 'Kecamatan'; //kustom nama label model

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('code')
                ->label('Code')
                ->required(),
            TextInput::make('name')
                ->label('Name')
                ->required(),
            Select::make('city_code')
                ->label('Kabupaten')
                ->relationship('city', 'name'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('code')
                ->label('Code')
                ->searchable(),
            TextColumn::make('name')
                ->label('Name')
                ->searchable(),
            TextColumn::make('city.name')
                ->label('Kabupaten')
                ->searchable(),
        ])
        ->filters([
            //
        ])
        ->actions([
            Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                //
            ]),
        ]);
    }

    public static function infolist(Infolist $infolist):Infolist
{
    return  $infolist
    ->schema([
        TextEntry::make('code')
            ->label('Code'),
        TextEntry::make('name')
            ->label('Name'),
        TextEntry::make('city.name')
            ->label('Kabupaten'),
    ]);
}


    public static function getRelations(): array
    {
        return [
            // RelationManagers\CitiesRelationManager::class,
            // RelationManagers\VillagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDistricts::route('/'),
            'create' => Pages\CreateDistrict::route('/create'),
            // 'edit' => Pages\EditDistrict::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('city_code', '3305'); // Adjust the condition as needed
    }
}
