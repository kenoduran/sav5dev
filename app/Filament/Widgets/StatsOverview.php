<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Customer;


class StatsOverview extends BaseWidget
{
    protected static ?string $pollingInteval = '15'; //Segundos en los que se refresca el dashboard si se quiere desactivar pornemos null

    protected function getStats(): array
    {
        return [
         //   Stat::make('Clientes ', '12'),
         //   Stat::make('Proyectos', Customer::count())
          //      ->description('Proyectos aprobados')
           //     ->descriptionIcon('heroicon-m-arrow-down-on-square-stack')
           //     ->color('success')
           //     ->chart([
            //        6, 4, 9, 5, 3, 7
            //    ]),

          //  Stat::make('Proyectos', Customer::count())
          //      ->description('Proyectos por terminar')
          ///      ->descriptionIcon('heroicon-m-academic-cap')
          //      ->color('danger')
          //      ->chart([
          //          6, 4, 9, 5, 3, 7
          //      ]),
        ];
    }
}
