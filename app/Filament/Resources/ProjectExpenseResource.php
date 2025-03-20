<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectExpenseResource\Pages;
use App\Filament\Resources\ProjectExpenseResource\RelationManagers;
use App\Models\ProjectExpense;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ProjectExpenseResource extends Resource
{
    protected static ?string $model = ProjectExpense::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationLabel = 'Project Expenses';
    protected static ?string $pluralLabel = 'Project Expenses';
    protected static ?string $modelLabel = 'Project Expense';
    protected static ?string $navigationGroup = 'Project Management';
    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->label('Expense ID')
                    ->disabled()
                    ->dehydrated(false)
                    ->columnSpanFull(),
                
                Forms\Components\Select::make('project_id')
                    ->relationship('project', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\Select::make('expense_type')
                    ->options([
                        'Materials' => 'Materials',
                        'Equipment' => 'Equipment',
                        'Labor' => 'Labor',
                        'Subcontractor' => 'Subcontractor',
                        'Permits' => 'Permits',
                        'Transportation' => 'Transportation',
                        'Food' => 'Food',
                        'Accommodation' => 'Accommodation',
                        'Tools' => 'Tools',
                        'Utilities' => 'Utilities',
                        'Insurance' => 'Insurance',
                        'Taxes' => 'Taxes',
                        'Other' => 'Other',
                    ])
                    ->required(),
                
                Forms\Components\TextInput::make('amount')
                    ->numeric()
                    ->required()
                    ->prefix('$'),
                
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
                
                Forms\Components\DatePicker::make('expense_date')
                    ->required()
                    ->default(now()),
                
                Forms\Components\TextInput::make('supplier')
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('receipt_number')
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('invoice_number')
                    ->maxLength(255),
                
                Forms\Components\Select::make('payment_method')
                    ->options([
                        'Cash' => 'Cash',
                        'Credit Card' => 'Credit Card',
                        'Debit Card' => 'Debit Card',
                        'Bank Transfer' => 'Bank Transfer',
                        'Check' => 'Check',
                        'PayPal' => 'PayPal',
                        'Other' => 'Other',
                    ]),
                
                Forms\Components\Select::make('status')
                    ->options([
                        'Pending' => 'Pending',
                        'Approved' => 'Approved',
                        'Rejected' => 'Rejected',
                        'Paid' => 'Paid',
                    ])
                    ->default('Pending')
                    ->required(),
                
                Forms\Components\Select::make('approved_by')
                    ->relationship('approver', 'name')
                    ->searchable()
                    ->nullable(),
                
                Forms\Components\DatePicker::make('approval_date')
                    ->after('expense_date'),
                
                Forms\Components\FileUpload::make('file_attachment')
                    ->disk('public')
                    ->directory('expense-receipts')
                    ->visibility('public')
                    ->acceptedFileTypes(['image/*', 'application/pdf']),
                
                Forms\Components\Textarea::make('notes')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                
                Forms\Components\Toggle::make('billable')
                    ->default(true),
                
                Forms\Components\Toggle::make('reimbursable')
                    ->default(false),
                
                Forms\Components\Hidden::make('created_by')
                    ->default(fn() => Auth::id() ?? '1'), // Fallback to 1 if no authenticated user
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('project.name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                
                Tables\Columns\TextColumn::make('expense_type')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('amount')
                    ->money('USD')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('expense_date')
                    ->date()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('supplier')
                    ->searchable()
                    ->toggleable(),
                
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'Pending',
                        'success' => 'Approved',
                        'danger' => 'Rejected',
                        'primary' => 'Paid',
                    ]),
                
                Tables\Columns\IconColumn::make('billable')
                    ->boolean()
                    ->toggleable(),
                
                Tables\Columns\IconColumn::make('reimbursable')
                    ->boolean()
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('creator.name')
                    ->label('Created By')
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
                Tables\Filters\SelectFilter::make('project')
                    ->relationship('project', 'name'),
                
                Tables\Filters\SelectFilter::make('expense_type')
                    ->options([
                        'Materials' => 'Materials',
                        'Equipment' => 'Equipment',
                        'Labor' => 'Labor',
                        'Subcontractor' => 'Subcontractor',
                        'Permits' => 'Permits',
                        'Transportation' => 'Transportation',
                        'Food' => 'Food',
                        'Accommodation' => 'Accommodation',
                        'Tools' => 'Tools',
                        'Utilities' => 'Utilities',
                        'Insurance' => 'Insurance',
                        'Taxes' => 'Taxes',
                        'Other' => 'Other',
                    ]),
                
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Pending' => 'Pending',
                        'Approved' => 'Approved',
                        'Rejected' => 'Rejected',
                        'Paid' => 'Paid',
                    ]),
                
                Tables\Filters\Filter::make('billable')
                    ->query(fn (Builder $query): Builder => $query->where('billable', true)),
                
                Tables\Filters\Filter::make('reimbursable')
                    ->query(fn (Builder $query): Builder => $query->where('reimbursable', true)),
                
                Tables\Filters\Filter::make('expense_date')
                    ->form([
                        Forms\Components\DatePicker::make('expense_from'),
                        Forms\Components\DatePicker::make('expense_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['expense_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('expense_date', '>=', $date),
                            )
                            ->when(
                                $data['expense_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('expense_date', '<=', $date),
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
                    Tables\Actions\BulkAction::make('updateStatus')
                        ->label('Update Status')
                        ->icon('heroicon-o-check')
                        ->form([
                            Forms\Components\Select::make('status')
                                ->options([
                                    'Pending' => 'Pending',
                                    'Approved' => 'Approved',
                                    'Rejected' => 'Rejected',
                                    'Paid' => 'Paid',
                                ])
                                ->required(),
                        ])
                        ->action(function (array $data, Collection $records): void {
                            foreach ($records as $record) {
                                $record->update([
                                    'status' => $data['status'],
                                    'approval_date' => in_array($data['status'], ['Approved', 'Paid']) ? now() : null,
                                    'approved_by' => in_array($data['status'], ['Approved', 'Paid']) ? Auth::id() : null,
                                ]);
                            }
                        }),
                ]),
            ])
            ->defaultSort('expense_date', 'desc');

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
            'index' => Pages\ListProjectExpenses::route('/'),
            'create' => Pages\CreateProjectExpense::route('/create'),
            'view' => Pages\ViewProjectExpense::route('/{record}'),
            'edit' => Pages\EditProjectExpense::route('/{record}/edit'),
        ];
    }
}