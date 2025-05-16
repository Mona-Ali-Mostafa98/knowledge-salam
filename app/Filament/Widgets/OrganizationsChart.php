<?php

namespace App\Filament\Widgets;

use App\Models\Organization;
use Filament\Widgets\ChartWidget;

class OrganizationsChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        self::$heading = __('system.organizations');
        $active = Organization::where('status_id', 2501)->count();
        $inactive = Organization::where('status_id', 2506)->count();

        return [
            'labels' => ['Active', 'InActive'],
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
        return 'doughnut';
    }
}
