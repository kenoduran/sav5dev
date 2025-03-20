<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MaterialsRelationManager extends RelationManager
{
    protected static string $relationship = 'materials';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'short_description')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('code')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('short_description')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('brand')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('family')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('cost')
                            ->numeric()
                            ->prefix('$'),
                        Forms\Components\TextInput::make('price1')
                            ->numeric()
                            ->prefix('$'),
                    ]),
                Forms\Components\TextInput::make('quantity')
                    ->numeric()
                    ->required()
                    ->default(1)
                    ->minValue(0.01)
                    ->step(0.01),
                Forms\Components\TextInput::make('unit')
                    ->maxLength(20)
                    ->placeholder('e.g., kg, m, unit'),
                Forms\Components\TextInput::make('unit_price')
                    ->numeric()
                    ->required()
                    ->prefix('$')
                    ->minValue(0.01)
                    ->default(fn (RelationManager $livewire, ?string $state): ?string => 
                        $state ?? null
                    ),
                Forms\Components\TextInput::make('total_price')
                    ->numeric()
                    ->prefix('$')
                    ->readOnly(),
                Forms\Components\DatePicker::make('assignment_date')
                    ->required()
                    ->default(now()),
                Forms\Components\Textarea::make('notes')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product.short_description')
            ->columns([
                Tables\Columns\TextColumn::make('product.code')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('product.short_description')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('quantity')
                    ->numeric(
                        decimalPlaces: 2,
                        decimalSeparator: '.',
                        thousandsSeparator: ',',
                    )
                    ->sortable(),
                Tables\Columns\TextColumn::make('unit')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('unit_price')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('assignment_date')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('assignment_date', 'desc');
    }
}