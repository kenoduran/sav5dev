<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Components;
use Filament\Infolists\Infolist;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class PhasesRelationManager extends RelationManager
{
    protected static string $relationship = 'phases';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
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
                Forms\Components\Select::make('status')
                    ->options([
                        'Pending' => 'Pending',
                        'In Progress' => 'In Progress',
                        'Completed' => 'Completed',
                        'Cancelled' => 'Cancelled',
                    ])
                    ->default('Pending')
                    ->required(),
                    Forms\Components\TextInput::make('progress_percentage')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->step(0.1)
                    ->suffix('%')
                    ->default(0) // Añadir esta línea
                    ->required(), // Añadir también esta para asegurar que siempre haya un valor,
                
                Forms\Components\TextInput::make('order')
                    ->numeric()
                    ->required()
                    ->default(fn ($livewire) => $livewire->ownerRecord->phases()->count() + 1),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->defaultSort('order')
            ->reorderable('order')
            ->columns([
                Tables\Columns\TextColumn::make('order')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('estimated_start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('estimated_end_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'secondary' => 'Pending',
                        'primary' => 'In Progress',
                        'success' => 'Completed',
                        'danger' => 'Cancelled',
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



                Tables\Columns\TextColumn::make('tasks_count')
                    ->counts('tasks')
                    ->label('Tasks')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Pending' => 'Pending',
                        'In Progress' => 'In Progress',
                        'Completed' => 'Completed',
                        'Cancelled' => 'Cancelled',
                    ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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

    protected function configureViewAction(Tables\Actions\ViewAction $action): void
    {
    $action
        ->infolist(
            fn (Infolist $infolist): Infolist => $infolist
                ->schema([
                    Components\Section::make('Información de la fase')
                        ->schema([
                            Components\TextEntry::make('name')
                                ->label('Nombre'),
                            Components\TextEntry::make('description')
                                ->label('Descripción'),
                            Components\TextEntry::make('status')
                                ->label('Estado')
                                ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'Completed' => 'success',
                                    'In Progress' => 'primary',
                                    'Pending' => 'secondary',
                                    'Cancelled' => 'danger',
                                    default => 'gray',
                                }),
                            Components\TextEntry::make('progress_percentage')
                                ->label('Progreso')
                                ->formatStateUsing(fn ($state) => number_format($state, 2) . '%'),
                        ]),
                    
                    Components\Section::make('Tareas')
                        ->headerActions([
                            \Filament\Infolists\Components\Actions\Action::make('createTask')
                                ->label('Nueva tarea')
                                ->icon('heroicon-o-plus')
                                ->form([
                                    Forms\Components\TextInput::make('name')
                                        ->label('Nombre de la tarea')
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\Textarea::make('description')
                                        ->label('Descripción')
                                        ->maxLength(65535),
                                    Forms\Components\Select::make('status')
                                        ->label('Estado')
                                        ->options([
                                            'Pending' => 'Pendiente',
                                            'In Progress' => 'En progreso',
                                            'Completed' => 'Completada',
                                            'Cancelled' => 'Cancelada',
                                        ])
                                        ->default('Pending')
                                        ->required(),
                                    Forms\Components\Select::make('responsible_id')
                                        ->label('Responsable')
                                        ->relationship('responsible', 'name')
                                        ->searchable()
                                        ->preload(),
                                    Forms\Components\TextInput::make('progress_percentage')
                                        ->label('Porcentaje de progreso')
                                        ->numeric()
                                        ->default(0)
                                        ->minValue(0)
                                        ->maxValue(100)
                                        ->step(0.1)
                                        ->suffix('%'),
                                    Forms\Components\Select::make('priority')
                                        ->label('Prioridad')
                                        ->options([
                                            'Low' => 'Baja',
                                            'Medium' => 'Media',
                                            'High' => 'Alta',
                                            'Urgent' => 'Urgente',
                                        ])
                                        ->default('Medium')
                                        ->required(),
                                ])
                                ->action(function (array $data, $record): void {
                                    $data['phase_id'] = $record->id;
                                    \App\Models\ProjectTask::create($data);
                                    
                                    Notification::make()
                                        ->title('Tarea creada')
                                        ->success()
                                        ->send();
                                        
                                    $this->getOwnerRecord()->refresh();
                                })
                        ])
                        ->schema([
                            Components\ViewEntry::make('tasks')
                                ->label('Lista de tareas')
                                ->view('filament.infolists.components.tasks-checklist'),
                        ]),
                ])
        );
    }
    
}