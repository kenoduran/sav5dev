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
                    ->required(),

                Forms\Components\TextInput::make('alias')
                    ->label('Alias')
                    ->maxLength(50),

                Forms\Components\TextInput::make('tax_id')
                    ->label('Tax ID')
                    ->unique(fn($get) => $get('record') ? Supplier::where('tax_id', $get('tax_id'))->where('id', '!=', $get('record')->id)->exists() : false) // Validación de único tax_id al editar
                    ->maxLength(50)
                    ->required(),

                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(fn($get) => $get('record') ? Supplier::where('email', $get('email'))->where('id', '!=', $get('record')->id)->exists() : false), // Validación de único correo al editar

                Forms\Components\TextInput::make('phone')
                    ->label('Phone')
                    ->tel(),

                Forms\Components\TextInput::make('secondary_phone')
                    ->label('Secondary Phone')
                    ->tel(),

                Forms\Components\TextInput::make('website')
                    ->label('Website')
                    ->url(),

                Forms\Components\TextInput::make('contact_person')
                    ->label('Contact Person'),

                Forms\Components\TextInput::make('contact_email')
                    ->label('Contact Email')
                    ->email(),

                Forms\Components\TextInput::make('contact_phone')
                    ->label('Contact Phone')
                    ->tel(),

                Forms\Components\TextInput::make('address')
                    ->label('Address'),

                Forms\Components\TextInput::make('city')
                    ->label('City'),

                Forms\Components\TextInput::make('state')
                    ->label('State'),

                Forms\Components\TextInput::make('zip_code')
                    ->label('ZIP Code'),

                Forms\Components\TextInput::make('country')
                    ->label('Country'),

                Forms\Components\Textarea::make('notes')
                    ->label('Additional Notes')
                    ->rows(3),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('name')
                    ->label('Company Name')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('alias')
                    ->label('Alias')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('tax_id')
                    ->label('Tax ID')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Phone')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('website')
                    ->label('Website')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('contact_person')
                    ->label('Contact Person')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->date()
                    ->toggleable(),
            ])
            ->filters([
                // Puedes agregar filtros personalizados aquí
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
