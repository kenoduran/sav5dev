<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;



class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Projects';
    protected static ?string $pluralLabel = 'Projects';
    protected static ?string $modelLabel = 'Project';
    protected static ?string $navigationGroup = 'Project Management';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Project Information')
                    ->schema([
                        Forms\Components\TextInput::make('id')
                            ->label('Project ID')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('code')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Client Information')
                    ->schema([
                        Forms\Components\Select::make('customer_id')
                            ->relationship('customer', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('contact_name')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('contact_phone')
                            ->tel()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('contact_email')
                            ->email()
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Location')
                    ->schema([
                        Forms\Components\Textarea::make('address')
                            ->required()
                            ->maxLength(65535),
                        Forms\Components\TextInput::make('city')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('state')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('zip_code')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('gps_coordinates')
                            ->maxLength(255)
                            ->placeholder('e.g., 40.7128,-74.0060'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Dates & Status')
                    ->schema([
                        Forms\Components\DatePicker::make('estimated_start_date')
                            ->required(),
                        Forms\Components\DatePicker::make('estimated_end_date')
                            ->required()
                            ->after('estimated_start_date'),
                        Forms\Components\DatePicker::make('actual_start_date')
                            ->after('estimated_start_date')
                            ->before('actual_end_date'),
                        Forms\Components\DatePicker::make('actual_end_date')
                            ->after('actual_start_date'),
                        Forms\Components\Select::make('status')
                            ->options([
                                'Proposal' => 'Proposal',
                                'Approved' => 'Approved',
                                'Planning' => 'Planning',
                                'In Progress' => 'In Progress',
                                'On Hold' => 'On Hold',
                                'Cancelled' => 'Cancelled',
                                'Completed' => 'Completed',
                            ])
                            ->default('Proposal')
                            ->required(),
                        Forms\Components\TextInput::make('progress_percentage')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->step(0.1)
                            ->suffix('%')
                            ->default(0) // Añadir esta línea
                            ->required(), // Añadir también esta para asegurar que siempre haya un valor
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Financial Information')
                    ->schema([
                        Forms\Components\TextInput::make('total_budget')
                            ->numeric()
                            ->required()
                            ->prefix('$'),
                        Forms\Components\TextInput::make('current_cost')
                            ->numeric()
                            ->default(0)
                            ->prefix('$'),
                        Forms\Components\TextInput::make('estimated_margin')
                            ->numeric()
                            ->suffix('%'),
                        Forms\Components\Select::make('currency')
                            ->options([
                                'USD' => 'USD',
                                'EUR' => 'EUR',
                                'GBP' => 'GBP',
                                'CAD' => 'CAD',
                                'MXN' => 'MXN',
                            ])
                            ->default('USD')
                            ->required(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Project Type & Priority')
                    ->schema([
                        Forms\Components\Select::make('project_type')
                            ->options([
                                'Construction' => 'Construction',
                                'Remodeling' => 'Remodeling',
                                'Electrical' => 'Electrical',
                                'Plumbing' => 'Plumbing',
                                'HVAC' => 'HVAC',
                                'Other' => 'Other',
                            ])
                            ->required(),
                        Forms\Components\Select::make('priority')
                            ->options([
                                'Low' => 'Low',
                                'Medium' => 'Medium',
                                'High' => 'High',
                                'Urgent' => 'Urgent',
                            ])
                            ->default('Medium')
                            ->required(),
                        Forms\Components\Select::make('complexity')
                            ->options([
                                'Low' => 'Low',
                                'Medium' => 'Medium',
                                'High' => 'High',
                                'Very High' => 'Very High',
                            ])
                            ->default('Medium')
                            ->required(),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Additional Information')
                    ->schema([
                        Forms\Components\TextInput::make('construction_permit_number')
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('permit_date'),
                        Forms\Components\Textarea::make('special_requirements')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('additional_notes')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('customer.name')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'secondary' => 'Proposal',
                        'success' => 'Approved',
                        'info' => 'Planning',
                        'primary' => 'In Progress',
                        'warning' => 'On Hold',
                        'danger' => 'Cancelled',
                        'success' => 'Completed',
                    ]),
                Tables\Columns\TextColumn::make('city')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('project_type')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('estimated_start_date')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('estimated_end_date')
                    ->date()
                    ->sortable()
                    ->toggleable(),
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
                Tables\Columns\TextColumn::make('total_budget')
                    ->money('USD')
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
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Proposal' => 'Proposal',
                        'Approved' => 'Approved',
                        'Planning' => 'Planning',
                        'In Progress' => 'In Progress',
                        'On Hold' => 'On Hold',
                        'Cancelled' => 'Cancelled',
                        'Completed' => 'Completed',
                    ]),
                Tables\Filters\SelectFilter::make('project_type')
                    ->options([
                        'Construction' => 'Construction',
                        'Remodeling' => 'Remodeling',
                        'Electrical' => 'Electrical',
                        'Plumbing' => 'Plumbing',
                        'HVAC' => 'HVAC',
                        'Other' => 'Other',
                    ]),
                Tables\Filters\SelectFilter::make('priority')
                    ->options([
                        'Low' => 'Low',
                        'Medium' => 'Medium',
                        'High' => 'High',
                        'Urgent' => 'Urgent',
                    ]),
                Tables\Filters\SelectFilter::make('customer')
                    ->relationship('customer', 'name'),
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
            RelationManagers\PhasesRelationManager::class,
            RelationManagers\MaterialsRelationManager::class,
            RelationManagers\EmployeesRelationManager::class,
            RelationManagers\DocumentsRelationManager::class,
            RelationManagers\ExpensesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'view' => Pages\ViewProject::route('/{record}'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}