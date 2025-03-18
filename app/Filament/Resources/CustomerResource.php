<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Models\Customer;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Customers';
    protected static ?string $pluralLabel = 'Customers';
    protected static ?string $modelLabel = 'Customer';
    protected static ?string $navigationGroup = 'Catalogs';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->label('Customer ID')
                    ->disabled()
                    ->dehydrated(false), // No lo envía en la solicitud

                Forms\Components\TextInput::make('name')
                    ->label('Full Name')
                    ->required(),

                Forms\Components\TextInput::make('alias')
                    ->label('Alias')
                    ->maxLength(50),

                Forms\Components\TextInput::make('tax_id')
                    ->label('Tax ID')
                    ->maxLength(50)
                    ->unique(fn($get) => $get('record') ? Customer::where('tax_id', $get('tax_id'))->where('id', '!=', $get('record')->id)->exists() : false), // Validación de único tax_id al editar

                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->unique(fn($get) => $get('record') ? Customer::where('email', $get('email'))->where('id', '!=', $get('record')->id)->exists() : false), // Validación de único email al editar

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
                TextColumn::make('id')->sortable()->toggleable(isToggledHiddenByDefault: true)->searchable(),
                TextColumn::make('name')->sortable()->toggleable()->searchable(),
                TextColumn::make('alias')->sortable()->toggleable()->searchable(),
                TextColumn::make('tax_id')->sortable()->toggleable()->searchable(),
                TextColumn::make('email')->sortable()->toggleable()->searchable(),
                TextColumn::make('phone')->sortable()->toggleable()->searchable(),
                TextColumn::make('secondary_phone')->sortable()->toggleable()->searchable(),
                TextColumn::make('website')->sortable()->toggleable()->searchable(),
                TextColumn::make('contact_person')->sortable()->toggleable()->searchable(),
                TextColumn::make('contact_email')->sortable()->toggleable()->searchable(),
                TextColumn::make('contact_phone')->sortable()->toggleable()->searchable(),
                TextColumn::make('city')->sortable()->toggleable()->searchable(),
                TextColumn::make('state')->sortable()->toggleable()->searchable(),
                TextColumn::make('zip_code')->sortable()->toggleable()->searchable(),
                TextColumn::make('country')->sortable()->toggleable()->searchable(),
                TextColumn::make('created_at')->sortable()->toggleable(),
                TextColumn::make('updated_at')->sortable()->toggleable(),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
