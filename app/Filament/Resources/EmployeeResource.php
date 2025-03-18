<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Models\Employee;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationLabel = 'Employees';
    protected static ?string $pluralLabel = 'Employees';
    protected static ?string $modelLabel = 'Employee';

    protected static ?string $navigationGroup = 'Catalogs';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->label('Employee ID')
                    ->disabled()
                    ->dehydrated(false), // No lo envía en la solicitud

                Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->required(),

                Forms\Components\TextInput::make('alias')
                    ->label('Alias')
                    ->maxLength(50),

                Forms\Components\TextInput::make('employee_id')
                    ->label('Employee ID Number')
                    ->unique(ignoreRecord: true)  // Permite la edición sin validar el ID como único
                    ->maxLength(50),

                Forms\Components\TextInput::make('email')
                    ->email()
                    ->unique(ignoreRecord: true)  // Permite la edición sin validar el email como único
                    ->required(),

                Forms\Components\TextInput::make('phone')
                    ->label('Phone')
                    ->tel(),

                Forms\Components\TextInput::make('secondary_phone')
                    ->label('Secondary Phone')
                    ->tel(),

                Forms\Components\TextInput::make('position')
                    ->label('Position'),

                Forms\Components\TextInput::make('department')
                    ->label('Department'),

                Forms\Components\DatePicker::make('hire_date')
                    ->label('Hire Date'),

                Forms\Components\TextInput::make('salary')
                    ->label('Salary')
                    ->numeric()
                    ->prefix('$'),

                Forms\Components\TextInput::make('website')
                    ->label('Personal Website')
                    ->url(),

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
                Tables\Columns\TextColumn::make('id')->label('ID')->searchable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('name')->label('Name')->toggleable()->searchable(),
                Tables\Columns\TextColumn::make('alias')->label('Alias')->toggleable()->searchable(),
                Tables\Columns\TextColumn::make('employee_id')->label('Employee ID')->toggleable()->searchable(),
                Tables\Columns\TextColumn::make('email')->label('Email')->toggleable()->searchable(),
                Tables\Columns\TextColumn::make('phone')->label('Phone')->toggleable()->searchable(),
                Tables\Columns\TextColumn::make('position')->label('Position')->toggleable()->searchable(),
                Tables\Columns\TextColumn::make('department')->label('Department')->toggleable()->searchable(),
                Tables\Columns\TextColumn::make('hire_date')->label('Hire Date')->date()->toggleable()->searchable(),
                Tables\Columns\TextColumn::make('salary')->label('Salary')->money('USD')->toggleable()->searchable(),
                Tables\Columns\TextColumn::make('created_at')->label('Created')->date(),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
