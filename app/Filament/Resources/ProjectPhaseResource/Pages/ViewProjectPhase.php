<?php

namespace App\Filament\Resources\ProjectPhaseResource\Pages;

use App\Filament\Resources\ProjectPhaseResource;
use App\Models\ProjectTask;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Components;
use Filament\Infolists\Infolist;

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

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->record)
            ->schema([
                Components\Section::make('Información de la fase')
                    ->schema([
                        Components\TextEntry::make('name')
                            ->label('Nombre'),
                        Components\TextEntry::make('description')
                            ->label('Descripción'),
                        Components\TextEntry::make('status')
                            ->label('Estado')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'Completed' => 'success',
                                'In Progress' => 'primary',
                                'Pending' => 'secondary',
                                'Cancelled' => 'danger',
                                default => 'gray',
                            }),
                        Components\TextEntry::make('progress_percentage')
                            ->label('Progreso')
                            ->formatStateUsing(fn ($state) => number_format($state, 2) . '%'),
                    ]),
                
                Components\Section::make('Tareas')
                    ->schema([
                        Components\ViewEntry::make('tasks')
                            ->label('Lista de tareas')
                            ->view('filament.infolists.components.tasks-checklist'),
                    ]),
            ]);
    }
}