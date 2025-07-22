<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Post;
use App\Models\User;
use Filament\Tables;
use App\Models\Order;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Laravolt\Indonesia\Models\Village;
use Filament\Tables\Columns\TextColumn;
use Laravolt\Indonesia\Models\District;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PostResource\Pages;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Posko'; // kustom nama label navigasi

    protected static ?string $modelLabel = 'Posko'; // kustom nama label model

    protected static ?string $slug = 'posko'; // kustom slug

    protected static ?string $navigationGroup = 'Manajemen Sistem'; // kustom nama grup navigasi

    protected static ?int $navigationSort = 2; // kustom urutan navigasi

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Select::make('district_id')
                    ->label('Kecamatan')
                    ->relationship('district', 'name')
                    ->options(fn() => District::where('city_code', 3305)->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('village_id')
                    ->label('Kelurahan')
                    ->relationship('village', 'name')
                    ->options(fn() => Village::whereHas('district', function ($query) {
                        $query->where('city_code', 3305);
                    })->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('latitude')
                    ->label('Latitude')
                    ->required(),
                TextInput::make('longitude')
                    ->label('Longitude')
                    ->required(),
                TextInput::make('link_maps')
                    ->label('Link Maps')
                    ->url()
                    ->required(),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'permanen' => 'Permanen',
                        'sementara' => 'Sementara',
                    ])
                    ->required(),
                // Select::make('users')
                //     ->label('Yang Bertanggungjawab')
                //     ->multiple()
                //     ->relationship('users', 'name')
                //     ->options(User::all()->pluck('name', 'id'))
                //     ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('district.name')
                    ->label('Kecamatan')
                    ->searchable(),
                TextColumn::make('village.name')
                    ->label('Kelurahan')
                    ->searchable(),
                BadgeColumn::make('status')
                    ->colors([
                        'success' => 'permanen',
                        'warning' => 'sementara',
                    ])
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
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
            // Define the relation with orders here if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
