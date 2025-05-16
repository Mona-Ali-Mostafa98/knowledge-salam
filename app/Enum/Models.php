<?php

namespace App\Enum;

use Filament\Support\Contracts\HasLabel;

enum Models: string implements HasLabel
{
    case Person = 'person';
    case Organization = 'organization';
    case Event = 'event';
    case Issue = 'issue';

    public function getLabel(): ?string
    {
        return __('enum'.'.'.$this->value);
    }
}
