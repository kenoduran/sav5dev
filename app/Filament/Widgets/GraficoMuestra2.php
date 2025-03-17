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
                    'data' => [125000, 531000, 872000, 234000, 98300, 662000]
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
