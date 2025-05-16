<?php

namespace App\Enum;

use Filament\Support\Contracts\HasLabel;

enum PersonActivity: string implements HasLabel
{
    case Active = 'active';
    case Inactive = 'inactive';

    public function getLabel(): ?string
    {
        return __('enum'.'.'.$this->value);
    }
}
