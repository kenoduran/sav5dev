<?php

namespace App\Filament\Resources\ProjectTaskResource\Pages;

use App\Filament\Resources\ProjectTaskResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProjectTask extends ViewRecord
{
    protected static string $resource = ProjectTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}