<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectEmployeeResource\Pages;
use App\Filament\Resources\ProjectEmployeeResource\RelationManagers;
use App\Models\ProjectEmployee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectEmployeeResource extends Resource
{
    protected static ?string $model = ProjectEmployee::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Project Team Members';
    protected static ?string $pluralLabel = 'Project Team Members';
    protected static ?string $modelLabel = 'Project Team Member';
    protected static ?string $navigationGroup = 'Project Management';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->label('Assignment ID')
                    ->disabled()
                    ->dehydrated(false)
                    ->columnSpanFull(),
                
                Forms\Components\Select::make('project_id')
                    ->relationship('project', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                
                Forms\Components\Select::make('employee_id')
                    ->relationship('employee', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                
                Forms\Components\TextInput::make('role')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\DatePicker::make('start_date')
                    ->required()
                    ->default(now()),
                
                Forms\Components\DatePicker::make('end_date')
                    ->after('start_date'),
                
                Forms\Components\TextInput::make('hours_allocated')
                    ->numeric()
                    ->step(0.01)
                    ->suffix('hrs'),
                
                Forms\Components\TextInput::make('hourly_rate')
                    ->numeric()
                    ->prefix('$')
                    ->step(0.01),
                
                Forms\Components\Textarea::make('responsibilities')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                
                Forms\Components\Textarea::make('notes')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('project.name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('employee.name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('role')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('hours_allocated')
                    ->numeric(
                        decimalPlaces: 2,
                        decimalSeparator: '.',
                        thousandsSeparator: ',',
                    )
                    ->suffix(' hrs')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('hourly_rate')
                    ->money('USD')
                    ->sortable()
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('estimated_cost')
                    ->money('USD')
                    ->state(function (ProjectEmployee $record): float {
                        return $record->hours_allocated && $record->hourly_rate 
                            ? $record->hours_allocated * $record->hourly_rate 
                            : 0;
                    })
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query->orderByRaw('hours_allocated * hourly_rate ' . $direction);
                    }),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('project')
                    ->relationship('project', 'name'),
                
                Tables\Filters\SelectFilter::make('employee')
                    ->relationship('employee', 'name'),
                
                Tables\Filters\Filter::make('currently_assigned')
                    ->query(fn (Builder $query): Builder => $query->where(function($query) {
                        $query->whereNull('end_date')
                            ->orWhere('end_date', '>=', now());
                    }))
                    ->label('Currently Assigned'),
                
                Tables\Filters\Filter::make('assignment_date')
                    ->form([
                        Forms\Components\DatePicker::make('assigned_from'),
                        Forms\Components\DatePicker::make('assigned_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['assigned_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('start_date', '>=', $date),
                            )
                            ->when(
                                $data['assigned_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('start_date', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListProjectEmployees::route('/'),
            'create' => Pages\CreateProjectEmployee::route('/create'),
            'view' => Pages\ViewProjectEmployee::route('/{record}'),
            'edit' => Pages\EditProjectEmployee::route('/{record}/edit'),
        ];
    }
}