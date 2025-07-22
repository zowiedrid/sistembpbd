<?php

namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\History;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\HistoryResource\Pages;

class HistoryResource extends Resource
{
    protected static ?string $model = History::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $slug = 'riwayat'; // Kustom slug

    protected static ?string $modelLabel = 'Riwayat'; // Kustom nama label model

    protected static ?string $navigationGroup = 'Manajemen Gudang'; // Kustom nama grup navigasi

    protected static ?int $navigationSort = 2; // Kustom urutan navigasi

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('history_code')
                    ->label('Kode Riwayat')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('adjustment_code')
                    ->label('Kode Penyesuaian Stok')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('order_code')
                    ->label('Kode Order')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->color(fn($record) => $record->status === 'order' ? 'success' : 'warning'),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Disable actions (edit, delete)
            ])
            ->bulkActions([
                // Disable bulk actions (delete)
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHistories::route('/'),
        ];
    }
}
