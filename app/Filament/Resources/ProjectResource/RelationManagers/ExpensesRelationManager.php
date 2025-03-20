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

class ExpensesRelationManager extends RelationManager
{
    protected static string $relationship = 'expenses';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
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
                Forms\Components\FileUpload::make('file_attachment')
                    ->disk('public')
                    ->directory('expense-receipts')
                    ->visibility('public')
                    ->acceptedFileTypes(['image/*', 'application/pdf']),
                Forms\Components\Textarea::make('notes')
                    ->maxLength(65535),
                Forms\Components\Toggle::make('billable')
                    ->default(true),
                Forms\Components\Toggle::make('reimbursable')
                    ->default(false),
                Forms\Components\Hidden::make('created_by')
                    ->default(fn() => Auth::id() ?? '1'), // Fallback to 1 if no authenticated user
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
            ->columns([
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
            ])
            ->filters([
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
            ])
            ->defaultSort('expense_date', 'desc');
    }
}