<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectPhaseResource\Pages;
use App\Filament\Resources\ProjectPhaseResource\RelationManagers;
use App\Models\ProjectPhase;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectPhaseResource extends Resource
{
    protected static ?string $model = ProjectPhase::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Project Phases';
    protected static ?string $pluralLabel = 'Project Phases';
    protected static ?string $modelLabel = 'Project Phase';
    protected static ?string $navigationGroup = 'Project Management';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->label('Phase ID')
                    ->disabled()
                    ->dehydrated(false)
                    ->columnSpanFull(),
                            
                Forms\Components\Select::make('project_id')
                    ->relationship('project', 'name')
                    ->preload()
                    ->searchable()
                    ->required()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('code')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('customer_id')
                            ->relationship('customer', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\DatePicker::make('estimated_start_date')
                            ->required(),
                        Forms\Components\DatePicker::make('estimated_end_date')
                            ->required(),
                        Forms\Components\TextInput::make('total_budget')
                            ->numeric()
                            ->required(),
                    ]),
                    
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                    
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                    
                Forms\Components\DatePicker::make('estimated_start_date')
                    ->required(),
                    
                Forms\Components\DatePicker::make('estimated_end_date')
                    ->after('estimated_start_date')
                    ->required(),
                    
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
                    ->default(0) // Añadir valor predeterminado explícito
                    ->required(), // Hacer que el campo sea obligatorio,
                
                Forms\Components\TextInput::make('order')
                    ->numeric()
                    ->required()
                    ->default(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('project.name')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('order')
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
                
                Tables\Columns\TextColumn::make('estimated_start_date')
                    ->date()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('estimated_end_date')
                    ->date()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('actual_start_date')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                    
                Tables\Columns\TextColumn::make('actual_end_date')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                    
                Tables\Columns\TextColumn::make('tasks_count')
                    ->counts('tasks')
                    ->label('Tasks'),
                    
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
                    
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Pending' => 'Pending',
                        'In Progress' => 'In Progress',
                        'Completed' => 'Completed',
                        'Cancelled' => 'Cancelled',
                    ]),
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
            ])
            ->defaultSort('project_id', 'asc')
            ->defaultSort('order', 'asc');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\TasksRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjectPhases::route('/'),
            'create' => Pages\CreateProjectPhase::route('/create'),
            'view' => Pages\ViewProjectPhase::route('/{record}'),
            'edit' => Pages\EditProjectPhase::route('/{record}/edit'),
        ];
    }
}