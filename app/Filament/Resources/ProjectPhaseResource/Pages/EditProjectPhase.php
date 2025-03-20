<?php

namespace App\Filament\Resources\ProjectPhaseResource\Pages;

use App\Filament\Resources\ProjectPhaseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProjectPhase extends EditRecord
{
    protected static string $resource = ProjectPhaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
