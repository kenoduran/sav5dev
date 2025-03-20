<?php

namespace App\Filament\Resources\ProjectEmployeeResource\Pages;

use App\Filament\Resources\ProjectEmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProjectEmployee extends ViewRecord
{
    protected static string $resource = ProjectEmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}