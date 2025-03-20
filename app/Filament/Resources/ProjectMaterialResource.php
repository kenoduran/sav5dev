<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectMaterialResource\Pages;
use App\Filament\Resources\ProjectMaterialResource\RelationManagers;
use App\Models\ProjectMaterial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectMaterialResource extends Resource
{
    protected static ?string $model = ProjectMaterial::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationLabel = 'Project Materials';
    protected static ?string $pluralLabel = 'Project Materials';
    protected static ?string $modelLabel = 'Project Material';
    protected static ?string $navigationGroup = 'Project Management';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->label('Material ID')
                    ->disabled()
                    ->dehydrated(false)
                    ->columnSpanFull(),
                
                Forms\Components\Select::make('project_id')
                    ->relationship('project', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('code')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('customer_id')
                            ->relationship('customer', 'name')
                            ->required(),
                    ]),
                
                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'short_description')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('code')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('short_description')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('brand')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('family')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('cost')
                            ->numeric()
                            ->prefix('$'),
                        Forms\Components\TextInput::make('price1')
                            ->numeric()
                            ->prefix('$'),
                    ]),
                
                Forms\Components\TextInput::make('quantity')
                    ->numeric()
                    ->required()
                    ->default(1)
                    ->minValue(0.01)
                    ->step(0.01),
                
                Forms\Components\TextInput::make('unit')
                    ->maxLength(20)
                    ->placeholder('e.g., kg, m, unit'),
                
                Forms\Components\TextInput::make('unit_price')
                    ->numeric()
                    ->required()
                    ->prefix('$')
                    ->minValue(0.01),
                
                Forms\Components\TextInput::make('total_price')
                    ->numeric()
                    ->prefix('$')
                    ->readOnly(),
                
                Forms\Components\DatePicker::make('assignment_date')
                    ->required()
                    ->default(now()),
                
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
                
                Tables\Columns\TextColumn::make('product.code')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('product.short_description')
                    ->label('Product')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                
                Tables\Columns\TextColumn::make('quantity')
                    ->numeric(
                        decimalPlaces: 2,
                        decimalSeparator: '.',
                        thousandsSeparator: ',',
                    )
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('unit')
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('unit_price')
                    ->money('USD')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('total_price')
                    ->money('USD')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('assignment_date')
                    ->date()
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
                
                Tables\Filters\SelectFilter::make('product_category')
                    ->relationship('product', 'family')
                    ->label('Product Category'),
                
                Tables\Filters\Filter::make('assignment_date')
                    ->form([
                        Forms\Components\DatePicker::make('assigned_from'),
                        Forms\Components\DatePicker::make('assigned_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['assigned_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('assignment_date', '>=', $date),
                            )
                            ->when(
                                $data['assigned_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('assignment_date', '<=', $date),
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
            ])
            ->defaultSort('assignment_date', 'desc');
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
            'index' => Pages\ListProjectMaterials::route('/'),
            'create' => Pages\CreateProjectMaterial::route('/create'),
            'view' => Pages\ViewProjectMaterial::route('/{record}'),
            'edit' => Pages\EditProjectMaterial::route('/{record}/edit'),
        ];
    }
}