<?php

namespace App\Filament\Widgets;

use App\Models\Person;
use Filament\Widgets\ChartWidget;

class PersonsChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        self::$heading = __('person.title');
        $active = Person::where('status', 'active')->count();
        $inactive = Person::where('status', 'inactive')->count();

        return [
            'labels' => [
                'ACTIVE',
                'INACTIVE',
            ],
            'datasets' => [
                [
                    'data' => [$active, $inactive],
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                    ],
                    'hoverOffset' => 4,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'polarArea';
    }
}
