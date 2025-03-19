<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationLabel = 'Products';
    protected static ?string $pluralLabel = 'Products';
    protected static ?string $modelLabel = 'Product';
    protected static ?string $navigationGroup = 'Catalogs';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->label('Product ID')
                    ->required()
                    ->maxLength(20)
                    ->unique(Product::class, 'id', ignoreRecord: true),

                Forms\Components\TextInput::make('code')
                    ->label('Code')
                    ->required()
                    ->maxLength(50),

                Forms\Components\FileUpload::make('pic')
                    ->label('Image')
                    ->image()
                    ->directory('products')
                    ->visibility('public')
                    ->imagePreviewHeight('100')
                    ->maxSize(2048)
                    ->nullable(),

                Forms\Components\TextInput::make('short_description')
                    ->label('Short Description')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('long_description')
                    ->label('Long Description')
                    ->rows(4)
                    ->nullable()
                    ->maxLength(1000),

                Forms\Components\TextInput::make('brand')
                    ->label('Brand')
                    ->required()
                    ->maxLength(100),

                Forms\Components\TextInput::make('family')
                    ->label('Family/Category')
                    ->required()
                    ->maxLength(100),

                Forms\Components\TextInput::make('price1')
                    ->label('Price 1')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->step(0.01),

                Forms\Components\TextInput::make('price2')
                    ->label('Price 2')
                    ->numeric()
                    ->prefix('$')
                    ->step(0.01)
                    ->nullable(),

                Forms\Components\TextInput::make('price3')
                    ->label('Price 3')
                    ->numeric()
                    ->prefix('$')
                    ->step(0.01)
                    ->nullable(),

                Forms\Components\TextInput::make('cost')
                    ->label('Cost')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->step(0.01),

                Forms\Components\TextInput::make('min_stock')
                    ->label('Minimum Stock')
                    ->integer()
                    ->default(0)
                    ->minValue(0),

                Forms\Components\TextInput::make('max_stock')
                    ->label('Maximum Stock')
                    ->integer()
                    ->default(0)
                    ->minValue(0),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                
                TextColumn::make('code')
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                
                Tables\Columns\ImageColumn::make('pic')
                    ->label('Image')
                    ->toggleable(),
                
                TextColumn::make('short_description')
                    ->label('Description')
                    ->sortable()
                    ->toggleable()
                    ->searchable()
                    ->limit(30),
                
                TextColumn::make('brand')
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                
                TextColumn::make('family')
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                
                TextColumn::make('price1')
                    ->money('USD')
                    ->sortable()
                    ->toggleable(),
                
                TextColumn::make('price2')
                    ->money('USD')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('price3')
                    ->money('USD')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('cost')
                    ->money('USD')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('min_stock')
                    ->sortable()
                    ->toggleable(),
                
                TextColumn::make('max_stock')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
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
                // Puedes agregar filtros personalizados aquí
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}