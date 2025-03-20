<?php

namespace App\Filament\Resources\ProjectMaterialResource\Pages;

use App\Filament\Resources\ProjectMaterialResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProjectMaterial extends ViewRecord
{
    protected static string $resource = ProjectMaterialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}