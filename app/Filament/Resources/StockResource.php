<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StockResource\Pages;
use App\Models\Stock;
use App\Models\StockItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StockResource extends Resource
{
    protected static ?string $model = Stock::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $slug = 'penyesuaian-stok'; // Kustom slug

    protected static ?string $modelLabel = 'Penyesuaian Stok'; // Kustom nama label model

    protected static ?string $navigationGroup = 'Manajemen Gudang'; // Kustom nama grup navigasi

    protected static ?int $navigationSort = 1; // Kustom urutan navigasi

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('adjustment_code')
                ->label('Kode Penyesuaian Stok')
                ->default('ADJ-' . random_int(100000, 999999))
                ->disabled()
                ->required(),
            Forms\Components\TextInput::make('title')
                ->label('Judul')
                ->required(),
            Forms\Components\Textarea::make('note')
                ->label('Catatan')
                ->nullable(),
            Forms\Components\Select::make('status')
                ->label('Status')
                ->options([
                    'pending' => 'Pending',
                ])
                ->default('pending')
                ->disabled(),
            Forms\Components\Repeater::make('items')
                ->label('Barang')
                ->relationship('items')
                ->schema([
                    Forms\Components\Select::make('item_id')
                        ->label('Item')
                        ->relationship('item', 'name')
                        ->required()
                        ->searchable(),
                    Forms\Components\TextInput::make('quantity')
                        ->label('Quantity')
                        ->required()
                        ->numeric(),
                ])
                ->columns(2)
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('adjustment_code')
                ->label('Kode Penyesuaian')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('title')
                ->label('Judul')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('status')
                ->label('Status')
                ->sortable(),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Dibuat Pada')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('updated_at')
                ->label('Diubah Pada')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])
        ->filters([
            //
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\Action::make('approved')
                ->label('Approved')
                ->icon('heroicon-o-check')
                ->action(function (Stock $record) {
                    if ($record->status !== 'pending') {
                        return;
                    }

                    foreach ($record->items as $item) {
                        $item->item->reduceStock($item->quantity);
                    }

                    $record->status = 'approved';
                    $record->save();
                }),
            Tables\Actions\Action::make('canceled')
                ->label('Canceled')
                ->icon('heroicon-o-x-mark')
                ->action(function (Stock $record) {
                    if ($record->status !== 'pending') {
                        return;
                    }

                    $record->status = 'canceled';
                    $record->save();
                }),
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
            'index' => Pages\ListStocks::route('/'),
            'create' => Pages\CreateStock::route('/create'),
            'edit' => Pages\EditStock::route('/{record}/edit'),
        ];
    }
}
