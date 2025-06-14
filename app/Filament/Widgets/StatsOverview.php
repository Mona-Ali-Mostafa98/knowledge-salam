<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use App\Models\Issues;
use App\Models\Organization;
use App\Models\Person;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(__('person.title'), Person::count())
                ->chart([9, 6, 18, 3, 15, 7, 20])
                ->color('success'),
            Stat::make(__('system.organizations'), Organization::count())
                ->chart([9, 6, 18, 3, 15, 7, 20])
                ->color('success'),
            Stat::make(__('system.events'), Event::count())
                ->chart([9, 6, 18, 3, 15, 7, 20])
                ->color('success'),

            Stat::make(__('system.issues'), Issues::count())
                ->chart([9, 6, 18, 3, 15, 7, 20])
                ->color('success'),
        ];
    }
}
