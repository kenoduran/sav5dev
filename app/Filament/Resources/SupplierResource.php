<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupplierResource\Pages;
use App\Models\Supplier;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationLabel = 'Suppliers';
    protected static ?string $pluralLabel = 'Suppliers';
    protected static ?string $modelLabel = 'Supplier';

    protected static ?string $navigationGroup = 'Catalogs';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->label('Supplier ID')
                    ->disabled()
                    ->dehydrated(false), // No lo envía en la solicitud

                Forms\Components\TextInput::make('name')
                    ->label('Company Name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('alias')
                    ->label('Alias')
                    ->maxLength(50),

                Forms\Components\TextInput::make('tax_id')
                    ->label('Tax ID')
                    ->unique(Supplier::class, 'tax_id', ignoreRecord: true) // Validación corregida
                    ->maxLength(50)
                    ->required(),

                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->unique(Supplier::class, 'email', ignoreRecord: true), // Validación corregida

                Forms\Components\TextInput::make('phone')
                    ->label('Phone')
                    ->tel()
                    ->maxLength(20),

                Forms\Components\TextInput::make('secondary_phone')
                    ->label('Secondary Phone')
                    ->tel()
                    ->maxLength(20),

                Forms\Components\TextInput::make('website')
                    ->label('Website')
                    ->url()
                    ->maxLength(255),

                Forms\Components\TextInput::make('contact_person')
                    ->label('Contact Person')
                    ->maxLength(100),

                Forms\Components\TextInput::make('contact_email')
                    ->label('Contact Email')
                    ->email()
                    ->maxLength(255),

                Forms\Components\TextInput::make('contact_phone')
                    ->label('Contact Phone')
                    ->tel()
                    ->maxLength(20),

                Forms\Components\TextInput::make('address')
                    ->label('Address')
                    ->maxLength(255),

                Forms\Components\TextInput::make('city')
                    ->label('City')
                    ->maxLength(100),

                Forms\Components\TextInput::make('state')
                    ->label('State')
                    ->maxLength(100),

                Forms\Components\TextInput::make('zip_code')
                    ->label('ZIP Code')
                    ->maxLength(20),

                Forms\Components\TextInput::make('country')
                    ->label('Country')
                    ->maxLength(100),

                Forms\Components\Textarea::make('notes')
                    ->label('Additional Notes')
                    ->rows(3)
                    ->maxLength(1000),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('name')
                    ->label('Company Name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('alias')
                    ->label('Alias')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('tax_id')
                    ->label('Tax ID')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('website')
                    ->label('Website')
                    ->url(fn (Supplier $record): string => $record->website)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('contact_person')
                    ->label('Contact Person')
                    ->searchable()
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('contact_email')
                    ->label('Contact Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('contact_phone')
                    ->label('Contact Phone')
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('city')
                    ->label('City')
                    ->searchable()
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('country')
                    ->label('Country')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
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
            'index' => Pages\ListSuppliers::route('/'),
            'create' => Pages\CreateSupplier::route('/create'),
            'edit' => Pages\EditSupplier::route('/{record}/edit'),
        ];
    }
}