<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectTaskResource\Pages;
use App\Filament\Resources\ProjectTaskResource\RelationManagers;
use App\Models\ProjectTask;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectTaskResource extends Resource
{
    protected static ?string $model = ProjectTask::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-circle';
    protected static ?string $navigationLabel = 'Tasks';
    protected static ?string $pluralLabel = 'Tasks';
    protected static ?string $modelLabel = 'Task';
    protected static ?string $navigationGroup = 'Project Management';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->label('Task ID')
                    ->disabled()
                    ->dehydrated(false)
                    ->columnSpanFull(),
                
                Forms\Components\Select::make('phase_id')
                    ->relationship('phase', 'name', function (Builder $query) {
                        $query->orderBy('project_id')
                              ->orderBy('order');
                    })
                    ->preload()
                    ->searchable()
                    ->required()
                    ->createOptionForm([
                        Forms\Components\Select::make('project_id')
                            ->relationship('project', 'name')
                            ->required(),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('estimated_start_date')
                            ->required(),
                        Forms\Components\DatePicker::make('estimated_end_date')
                            ->required(),
                        Forms\Components\TextInput::make('order')
                            ->numeric()
                            ->required()
                            ->default(1),
                    ])
                    ->optionsLimit(50),
                
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                
                Forms\Components\DatePicker::make('estimated_start_date'),
                
                Forms\Components\DatePicker::make('estimated_end_date')
                    ->after('estimated_start_date'),
                
                Forms\Components\DatePicker::make('actual_start_date'),
                
                Forms\Components\DatePicker::make('actual_end_date')
                    ->after('actual_start_date'),
                
                Forms\Components\TextInput::make('estimated_duration')
                    ->numeric()
                    ->suffix('hours')
                    ->minValue(0),
                
                Forms\Components\TextInput::make('actual_duration')
                    ->numeric()
                    ->suffix('hours')
                    ->minValue(0),
                
                Forms\Components\Select::make('status')
                    ->options([
                        'Pending' => 'Pending',
                        'In Progress' => 'In Progress',
                        'Completed' => 'Completed',
                        'Cancelled' => 'Cancelled',
                    ])
                    ->default('Pending')
                    ->required(),
                
                Forms\Components\Select::make('responsible_id')
                    ->relationship('responsible', 'name')
                    ->searchable()
                    ->preload(),
                
                Forms\Components\TextInput::make('progress_percentage')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->step(0.1)
                    ->suffix('%')
                    ->default(0) // Añadir esta línea
                    ->required(), // Añadir también esta para asegurar que siempre haya un valor,
                
                Forms\Components\Select::make('priority')
                    ->options([
                        'Low' => 'Low',
                        'Medium' => 'Medium',
                        'High' => 'High',
                        'Urgent' => 'Urgent',
                    ])
                    ->default('Medium')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('phase.project.name')
                    ->label('Project')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('phase.name')
                    ->label('Phase')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('responsible.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'secondary' => 'Pending',
                        'primary' => 'In Progress',
                        'success' => 'Completed',
                        'danger' => 'Cancelled',
                    ]),
                
                Tables\Columns\BadgeColumn::make('priority')
                    ->colors([
                        'success' => 'Low',
                        'info' => 'Medium',
                        'warning' => 'High',
                        'danger' => 'Urgent',
                    ]),
                
                Tables\Columns\TextColumn::make('progress_percentage')
                    ->suffix('%')
                    ->formatStateUsing(fn ($state) => number_format($state, 2))
                    ->badge()
                    ->color(fn ($state) => 
                        match(true) {
                            $state >= 75 => 'success',
                            $state >= 50 => 'warning',
                            $state >= 25 => 'info',
                            default => 'danger',
                        }
                    )
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('estimated_start_date')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('estimated_end_date')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                
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
                Tables\Filters\SelectFilter::make('phase')
                    ->relationship('phase', 'name'),
                
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Pending' => 'Pending',
                        'In Progress' => 'In Progress',
                        'Completed' => 'Completed',
                        'Cancelled' => 'Cancelled',
                    ]),
                
                Tables\Filters\SelectFilter::make('priority')
                    ->options([
                        'Low' => 'Low',
                        'Medium' => 'Medium',
                        'High' => 'High',
                        'Urgent' => 'Urgent',
                    ]),
                
                Tables\Filters\SelectFilter::make('responsible')
                    ->relationship('responsible', 'name'),
                
                Tables\Filters\Filter::make('overdue')
                    ->query(fn (Builder $query): Builder => $query->where('estimated_end_date', '<', now())
                        ->whereNotIn('status', ['Completed', 'Cancelled']))
                    ->label('Overdue Tasks'),
                
                Tables\Filters\Filter::make('today')
                    ->query(fn (Builder $query): Builder => $query->whereDate('estimated_start_date', '<=', now())
                        ->whereDate('estimated_end_date', '>=', now())
                        ->where('status', '!=', 'Completed'))
                    ->label('Today\'s Tasks'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('updateStatus')
                        ->label('Update Status')
                        ->icon('heroicon-o-check')
                        ->form([
                            Forms\Components\Select::make('status')
                                ->options([
                                    'Pending' => 'Pending',
                                    'In Progress' => 'In Progress',
                                    'Completed' => 'Completed',
                                    'Cancelled' => 'Cancelled',
                                ])
                                ->required(),
                        ])
                        ->action(function (array $data, Collection $records): void {
                            foreach ($records as $record) {
                                $record->update(['status' => $data['status']]);
                            }
                        }),
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
            'index' => Pages\ListProjectTasks::route('/'),
            'create' => Pages\CreateProjectTask::route('/create'),
            'view' => Pages\ViewProjectTask::route('/{record}'),
            'edit' => Pages\EditProjectTask::route('/{record}/edit'),
        ];
    }
}