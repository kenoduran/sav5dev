<?php

namespace App\Filament\Resources\ProjectExpenseResource\Pages;

use App\Filament\Resources\ProjectExpenseResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProjectExpense extends ViewRecord
{
    protected static string $resource = ProjectExpenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}