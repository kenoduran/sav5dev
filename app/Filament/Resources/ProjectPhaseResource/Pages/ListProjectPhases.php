<?php

namespace App\Filament\Resources\ProjectPhaseResource\Pages;

use App\Filament\Resources\ProjectPhaseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProjectPhases extends ListRecords
{
    protected static string $resource = ProjectPhaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
