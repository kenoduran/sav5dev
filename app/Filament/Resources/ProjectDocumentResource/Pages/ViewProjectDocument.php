<?php

namespace App\Filament\Resources\ProjectDocumentResource\Pages;

use App\Filament\Resources\ProjectDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProjectDocument extends ViewRecord
{
    protected static string $resource = ProjectDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
            Actions\Action::make('download')
                ->label('Download')
                ->icon('heroicon-o-arrow-down-tray')
                ->url(fn ($record) => asset('storage/' . $record->file_path))
                ->openUrlInNewTab(),
        ];
    }
}