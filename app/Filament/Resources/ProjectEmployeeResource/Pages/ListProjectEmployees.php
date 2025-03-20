<?php

namespace App\Filament\Resources\ProjectEmployeeResource\Pages;

use App\Filament\Resources\ProjectEmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProjectEmployees extends ListRecords
{
    protected static string $resource = ProjectEmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
