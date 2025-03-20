<?php

namespace App\Filament\Resources\ProjectMaterialResource\Pages;

use App\Filament\Resources\ProjectMaterialResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProjectMaterials extends ListRecords
{
    protected static string $resource = ProjectMaterialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
