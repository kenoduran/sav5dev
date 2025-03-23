<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;



use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectsRelationManager extends RelationManager
{
    protected static string $relationship = 'projects';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
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
                Forms\Components\TextInput::make('contact_name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('contact_phone')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('contact_email')
                    ->email()
                    ->maxLength(255),
                Forms\Components\Textarea::make('address')
                    ->required()
                    ->maxLength(65535),
                Forms\Components\TextInput::make('city')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('estimated_start_date')
                    ->required(),
                Forms\Components\DatePicker::make('estimated_end_date')
                    ->required()
                    ->after('estimated_start_date'),
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
                Forms\Components\TextInput::make('total_budget')
                    ->numeric()
                    ->required()
                    ->prefix('$'),
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
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
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