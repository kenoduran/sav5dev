<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectDocumentResource\Pages;
use App\Filament\Resources\ProjectDocumentResource\RelationManagers;
use App\Models\ProjectDocument;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ProjectDocumentResource extends Resource
{
    protected static ?string $model = ProjectDocument::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Project Documents';
    protected static ?string $pluralLabel = 'Project Documents';
    protected static ?string $modelLabel = 'Project Document';
    protected static ?string $navigationGroup = 'Project Management';
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->label('Document ID')
                    ->disabled()
                    ->dehydrated(false)
                    ->columnSpanFull(),
                
                Forms\Components\Select::make('project_id')
                    ->relationship('project', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                
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
                    ->maxLength(65535)
                    ->columnSpanFull(),
                
                Forms\Components\FileUpload::make('file_path')
                    ->required()
                    ->disk('public')
                    ->directory('project-documents')
                    ->visibility('public')
                    ->acceptedFileTypes(['application/pdf', 'image/*', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']),
                
                Forms\Components\Select::make('uploaded_by')
                    ->relationship('uploader', 'name')
                    ->required()
                    ->default(fn() => Auth::id() ?? '1') // Fallback to 1 if no authenticated user
                    ->disabled()
                    ->dehydrated(),
                
                Forms\Components\TextInput::make('version')
                    ->default('1.0')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('project.name')
                    ->searchable()
                    ->sortable(),
                
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
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('project')
                    ->relationship('project', 'name'),
                
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
                
                Tables\Filters\SelectFilter::make('uploader')
                    ->relationship('uploader', 'name'),
                
                Tables\Filters\Filter::make('upload_date')
                    ->form([
                        Forms\Components\DatePicker::make('uploaded_from'),
                        Forms\Components\DatePicker::make('uploaded_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['uploaded_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('upload_date', '>=', $date),
                            )
                            ->when(
                                $data['uploaded_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('upload_date', '<=', $date),
                            );
                    }),
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
            ])
            ->defaultSort('upload_date', 'desc');
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
            'index' => Pages\ListProjectDocuments::route('/'),
            'create' => Pages\CreateProjectDocument::route('/create'),
            'view' => Pages\ViewProjectDocument::route('/{record}'),
            'edit' => Pages\EditProjectDocument::route('/{record}/edit'),
        ];
    }
}