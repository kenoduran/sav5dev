<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class DocumentsRelationManager extends RelationManager
{
    protected static string $relationship = 'documents';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('document_type')
                    ->options([
                        'Contract' => 'Contract',
                        'Blueprint' => 'Blueprint',
                        'Permit' => 'Permit',
                        'Invoice' => 'Invoice',
                        'Budget' => 'Budget',
                        'Report' => 'Report',
                        'Other' => 'Other',
                    ])
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535),
                Forms\Components\FileUpload::make('file_path')
                    ->required()
                    ->disk('public')
                    ->directory('project-documents')
                    ->visibility('public')
                    ->acceptedFileTypes(['application/pdf', 'image/*', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']),
                Forms\Components\Hidden::make('uploaded_by')
                    ->default(fn() => Auth::id() ?? '1'), // Fallback to 1 if no authenticated user
                Forms\Components\TextInput::make('version')
                    ->default('1.0')
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('document_type')
                    ->colors([
                        'primary' => 'Contract',
                        'info' => 'Blueprint',
                        'warning' => 'Permit',
                        'success' => 'Invoice',
                        'danger' => 'Budget',
                        'secondary' => 'Report',
                        'default' => 'Other',
                    ]),
                Tables\Columns\TextColumn::make('version')
                    ->sortable(),
                Tables\Columns\TextColumn::make('upload_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('uploader.name')
                    ->label('Uploaded By')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('document_type')
                    ->options([
                        'Contract' => 'Contract',
                        'Blueprint' => 'Blueprint',
                        'Permit' => 'Permit',
                        'Invoice' => 'Invoice',
                        'Budget' => 'Budget',
                        'Report' => 'Report',
                        'Other' => 'Other',
                    ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('download')
                    ->label('Download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn ($record) => asset('storage/' . $record->file_path))
                    ->openUrlInNewTab(),
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