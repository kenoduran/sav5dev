<?php

namespace App\Filament\Resources\ProjectExpenseResource\Pages;

use App\Filament\Resources\ProjectExpenseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProjectExpenses extends ListRecords
{
    protected static string $resource = ProjectExpenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
