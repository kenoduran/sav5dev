<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
}