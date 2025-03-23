<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class GraficoMuestra2 extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Ingresos',
                    'data' => [428000, 835000, 1872000, 934000, 148300, 1162000]
                ]
                ],

                'labels' => ['Ene', 'Feb', 'Mar', 'Abri', 'May', 'Jun']
            
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
