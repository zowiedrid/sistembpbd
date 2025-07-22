<?php

namespace App\Filament\Clusters\Daerah\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use App\Filament\Clusters\Daerah;
use Laravolt\Indonesia\Models\Village;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Clusters\Daerah\Resources\VillageResource\Pages;
use App\Filament\Clusters\Daerah\Resources\VillageResource\RelationManagers;

class VillageResource extends Resource
{
    protected static ?string $model = Village::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $cluster = Daerah::class;

    protected static ?string $navigationLabel = 'Desa'; // Custom navigation label

    protected static ?string $modelLabel = 'Desa'; // Custom model label

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
                Select::make('district_code')
                    ->label('Kecamatan')
                    ->relationship('district', 'name'),
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
                TextColumn::make('district.name')
                    ->label('Kecamatan')
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

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('code')
                    ->label('Code'),
                TextEntry::make('name')
                    ->label('Name'),
                TextEntry::make('district.name')
                    ->label('Kecamatan'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // RelationManagers\DistrictsRelationManager::class,
            // RelationManagers\CitiesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVillages::route('/'),
            'create' => Pages\CreateVillage::route('/create'),
            'edit' => Pages\EditVillage::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('district.city', function ($query) {
                $query->where('id', 192);
            });
    }
}
