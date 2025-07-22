<?php

namespace App\Filament\Clusters\Barang\Resources;

use App\Enums\UnitItem;
use App\Filament\Clusters\Barang;
use App\Filament\Clusters\Barang\Resources\ItemResource\Pages;
use App\Filament\Clusters\Barang\Resources\ItemResource\RelationManagers;
use App\Models\Item;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $slug = 'logistik'; //kustom slug

    protected static ?string $modelLabel = 'Logistik'; //kustom nama label model

    protected static ?string $cluster = Barang::class;

    protected static ?int $navigationSort = -1; //kustom urutan navigasi

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->live(onBlur: true)
                ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                    if ($operation !== 'create') {
                        return;
                    }

                    $set('sku', strtolower(str_replace(' ', '-', $state)));
                }),
                Forms\Components\Select::make('category_id')

                    ->searchable()
                    ->preload()
                    ->required()
                    ->relationship('category', 'name'),
                Forms\Components\Select::make('brand_id')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->relationship('brand', 'name'),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('quantity')
                    ->required()
                    ->numeric(),
                    Forms\Components\Select::make('unit')
    ->options([
        'pcs' => 'PCS',
        'kg' => 'KG',
        'gram' => 'Gram',
        'liter' => 'Liter',
        'lusin' => 'Lusin',
    ])
    ->required(),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\Toggle::make('is_visible')
                    ->required(),
                Forms\Components\TextInput::make('sku')
                ->label('SKU')
                ->required()
                ->maxLength(255)
                ->disabled(true),
                Forms\Components\TextInput::make('barcode')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('brand.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                    Tables\Columns\TextColumn::make('unit')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_visible')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable(),
                Tables\Columns\TextColumn::make('barcode')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListItems::route('/'),
            'create' => Pages\CreateItem::route('/create'),
            'edit' => Pages\EditItem::route('/{record}/edit'),
        ];
    }
}
