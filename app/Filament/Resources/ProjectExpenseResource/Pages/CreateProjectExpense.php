<?php

namespace App\Filament\Resources\ProjectExpenseResource\Pages;

use App\Filament\Resources\ProjectExpenseResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProjectExpense extends CreateRecord
{
    protected static string $resource = ProjectExpenseResource::class;
}
