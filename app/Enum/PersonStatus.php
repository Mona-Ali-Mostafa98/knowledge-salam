<?php

namespace App\Enum;

use Filament\Support\Contracts\HasLabel;

enum PersonStatus: string implements HasLabel
{
    case Alive = 'alive';
    case Deceased = 'deceased';
    case Working = 'working';
    case NotWorking = 'not_working';
    case Retired = 'retired';
    case Detained = 'detained';

    public function getLabel(): ?string
    {
        return __('enum'.'.'.$this->value);
    }
}
