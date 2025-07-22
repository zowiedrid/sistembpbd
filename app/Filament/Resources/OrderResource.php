<?php

namespace App\Filament\Resources;

    use Filament\Forms;
    use App\Models\Item;
    use Filament\Tables;
    use App\Models\Order;
    use Filament\Forms\Form;
    use App\Enums\OrderStatus;
    use Filament\Tables\Table;
    use Illuminate\Support\Carbon;
    use Filament\Resources\Resource;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Builder;
    use App\Filament\Resources\OrderResource\Pages;
    use App\Filament\Clusters\Barang\Resources\ItemResource;
    use App\Filament\Resources\OrderResource\RelationManagers;
    class OrderResource extends Resource

    {
        protected static ?string $model = Order::class;

        protected static ?string $slug = 'orders';

        protected static ?string $recordTitleAttribute = 'id';

        protected static ?string $navigationGroup = 'Kebencanaan';

        protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

        protected static ?int $navigationSort = 1;

        public static function form(Form $form): Form
        {
            return $form
                ->schema([
                    Forms\Components\Group::make()
                        ->schema([
                            Forms\Components\Section::make('Order Details')
                                ->schema(static::getDetailsFormSchema())
                                ->columns(2),

                            Forms\Components\Section::make('Order Items')
                                ->headerActions([
                                    Forms\Components\Actions\Action::make('reset')
                                        ->modalHeading('Are you sure?')
                                        ->modalDescription('All existing items will be removed from the order.')
                                        ->requiresConfirmation()
                                        ->color('danger')
                                        ->action(fn (Forms\Set $set) => $set('orderItems', [])),
                                ])
                                ->schema([
                                    static::getItemsRepeater(),
                                ]),
                        ])
                        ->columnSpan(['lg' => fn (?Order $record) => $record === null ? 3 : 2]),

                    Forms\Components\Section::make('Timestamps')
                        ->schema([
                            Forms\Components\Placeholder::make('created_at')
                                ->label('Created at')
                                ->content(fn (Order $record): ?string => $record->created_at?->diffForHumans()),

                            Forms\Components\Placeholder::make('updated_at')
                                ->label('Last modified at')
                                ->content(fn (Order $record): ?string => $record->updated_at?->diffForHumans()),
                        ])
                        ->columnSpan(['lg' => 1])
                        ->hidden(fn (?Order $record) => $record === null),
                ])
                ->columns(3);
        }

        public static function table(Table $table): Table
        {
            return $table
                ->columns([
                    Tables\Columns\TextColumn::make('code')
                        ->searchable()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('user.name')
                        ->label('User Name')
                        ->searchable()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('disaster.name')
                        ->label('Disaster')
                        ->searchable()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('post.name')
                        ->label('Destination Post')
                        ->searchable()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('status')
                        ->badge(fn (Order $record): string => $record->status->getLabel())
                        ->color(fn (Order $record): string => $record->status->getColor()),
                    Tables\Columns\TextColumn::make('created_at')
                        ->label('Order Date')
                        ->date()
                        ->toggleable(),
                ])
                ->filters([
                    Tables\Filters\Filter::make('created_at')
                        ->form([
                            Forms\Components\DatePicker::make('created_from')
                                ->placeholder(fn ($state): string => 'Dec 18, ' . now()->subYear()->format('Y')),
                            Forms\Components\DatePicker::make('created_until')
                                ->placeholder(fn ($state): string => now()->format('M d, Y')),
                        ])
                        ->query(function (Builder $query, array $data): Builder {
                            return $query
                                ->when(
                                    $data['created_from'] ?? null,
                                    fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                                )
                                ->when(
                                    $data['created_until'] ?? null,
                                    fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                                );
                        })
                        ->indicateUsing(function (array $data): array {
                            $indicators = [];
                            if ($data['created_from'] ?? null) {
                                $indicators['created_from'] = 'Order from ' . Carbon::parse($data['created_from'])->toFormattedDateString();
                            }
                            if ($data['created_until'] ?? null) {
                                $indicators['created_until'] = 'Order until ' . Carbon::parse($data['created_until'])->toFormattedDateString();
                            }

                            return $indicators;
                        }),
                ])
                ->actions([
                    Tables\Actions\EditAction::make(),
                ])
                ->groupedBulkActions([
                    Tables\Actions\DeleteBulkAction::make(),
                ])
                ->groups([
                    Tables\Grouping\Group::make('created_at')
                        ->label('Order Date')
                        ->date()
                        ->collapsible(),
                ]);
        }

        public static function getRelations(): array
        {
            return [
                // RelationManagers\OrderItemsRelationManager::class,
            ];
        }

        public static function getPages(): array
        {
            return [
                'index' => Pages\ListOrders::route('/'),
                'create' => Pages\CreateOrder::route('/create'),
                'edit' => Pages\EditOrder::route('/{record}/edit'),
            ];
        }

        /** @return Builder<Order> */
        public static function getEloquentQuery(): Builder
        {
            return parent::getEloquentQuery();
        }

        public static function getGloballySearchableAttributes(): array
        {
            return ['id', 'user.name'];
        }

        public static function getGlobalSearchResultDetails(Model $record): array
        {
            /** @var Order $record */

            return [
                'User' => optional($record->user)->name,
            ];
        }

        /** @return Builder<Order> */
        public static function getGlobalSearchEloquentQuery(): Builder
        {
            return parent::getGlobalSearchEloquentQuery()->with(['user', 'orderItems']);
        }

        public static function getNavigationBadge(): ?string
        {
            return (string) static::$model::where('status', 'new')->count();
        }

        /** @return Forms\Components\Component[] */
        public static function getDetailsFormSchema(): array
        {
            return [
                Forms\Components\TextInput::make('code')
                    ->default('ORD-' . random_int(100000, 999999))
                    ->disabled()
                    ->dehydrated()
                    ->required()
                    ->maxLength(32)
                    ->unique(Order::class, 'code', ignoreRecord: true),
                Forms\Components\Select::make('disaster_id')
                    ->relationship('disaster', 'name')
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->label('Order Creator')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('post_id')
                    ->label('Destination Post')
                    ->relationship('post', 'name')
                    ->searchable()
                    ->required(),
                Forms\Components\Toggle::make('show_distribution_team')
                    ->label('Show Distribution Team')
                    ->reactive()
                    ->inline(false),
                Forms\Components\Select::make('user_ids')
                    ->label('Distribution Team')
                    ->relationship('users', 'name')
                    ->multiple()
                    ->searchable()
                    ->hidden(fn (Forms\Get $get) => !$get('show_distribution_team'))
                    ->required(fn (Forms\Get $get) => $get('show_distribution_team')),
                Forms\Components\ToggleButtons::make('status')
                    ->inline()
                    ->options(OrderStatus::class)
                    ->required(),
            ];
        }

        public static function getItemsRepeater(): Forms\Components\Repeater
        {
            return Forms\Components\Repeater::make('orderItems')
                ->relationship()
                ->schema([
                    Forms\Components\TextInput::make('barcode')
                        ->label('Barcode')
                        ->reactive()
                        ->afterStateUpdated(function ($state, Forms\Set $set) {
                            if ($state) {
                                // Assuming you have a method to find an item by barcode
                                $item = Item::where('barcode', $state)->first();
                                if ($item) {
                                    $set('item_id', $item->id);
                                    // Optionally set the quantity or any other fields based on the item
                                }
                            }
                        })
                        ->columnSpan([
                            'md' => 2,
                        ]),

                    Forms\Components\Select::make('item_id')
                        ->label('Item')
                        ->relationship('item', 'name')
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($state, Forms\Set $set) {
                            if ($state) {
                                // Assuming you have a method to get the barcode when an item is selected
                                $item = Item::find($state);
                                if ($item) {
                                    $set('barcode', $item->barcode);
                                    // Optionally set the quantity or any other fields based on the item
                                }
                            }
                        })
                        ->distinct()
                        ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                        ->columnSpan([
                            'md' => 5,
                        ])
                        ->searchable(),

                    Forms\Components\TextInput::make('quantity')
                        ->label('Quantity')
                        ->numeric()
                        ->default(1)
                        ->columnSpan([
                            'md' => 2,
                        ])
                        ->required(),
                ])
                ->extraItemActions([
                    Forms\Components\Actions\Action::make('openItem')
                        ->tooltip('Open item')
                        ->icon('heroicon-m-arrow-top-right-on-square')
                        ->url(function (array $arguments, Forms\Components\Repeater $component): ?string {
                            $itemData = $component->getRawItemState($arguments['item']);

                            $item = \App\Models\Item::find($itemData['item_id']);

                            if (!$item) {
                                return null;
                            }

                            return ItemResource::getUrl('edit', ['record' => $item]);
                        }, shouldOpenInNewTab: true)
                        ->hidden(fn (array $arguments, Forms\Components\Repeater $component): bool => blank($component->getRawItemState($arguments['item'])['item_id'])),
                ])
                ->defaultItems(1)
                ->hiddenLabel()
                ->columns([
                    'md' => 10,
                ])
                ->required();
        }
    }
