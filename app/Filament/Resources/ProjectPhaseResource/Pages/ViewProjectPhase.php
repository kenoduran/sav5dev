<?php


namespace App\Filament\Resources\ProjectPhaseResource\Pages;

use App\Filament\Resources\ProjectPhaseResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProjectPhase extends ViewRecord
{
    protected static string $resource = ProjectPhaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}