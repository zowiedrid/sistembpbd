<?php

namespace App\Filament\Clusters\Daerah\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use App\Filament\Clusters\Daerah;
use Laravolt\Indonesia\Models\City;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Clusters\Daerah\Resources\CityResource\Pages;
use App\Filament\Clusters\Daerah\Resources\CityResource\RelationManagers;

class CityResource extends Resource
{
    protected static ?string $model = City::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $cluster = Daerah::class;

    protected static ?string $navigationLabel = 'Kabupaten'; //kustom nama label navigasi

    protected static ?string $modelLabel = 'Kabupaten'; //kustom nama label model

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
            Select::make('province_code')
                ->label('Province')
                ->relationship('province', 'name'),
            // FileUpload::make('logo')
            //     ->label('Logo')
            //     ->disk('public')
            //     ->directory('indonesia-logo')
            //     ->visibility('public'),
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
            TextColumn::make('province.name')
                ->label('Province')
                ->searchable(),
            // ImageColumn::make('logo_path')
            //     ->label('Logo')
            //     ->url(true),
        ])
        ->filters([
            //
        ])
        ->actions([
            // Tables\Actions\EditAction::make(),
            Tables\Actions\ViewAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                // Tables\Actions\DeleteBulkAction::make(),

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
        TextEntry::make('province.name')
            ->label('Province'),
    ]);
}

public static function getRelations(): array
{
    return [
        // RelationManagers\DistrictsRelationManager::class,
        // RelationManagers\VillagesRelationManager::class,
    ];
}

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCities::route('/'),
            'create' => Pages\CreateCity::route('/create'),
            // 'edit' => Pages\EditCity::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()->where('code', '3305');
}
}
