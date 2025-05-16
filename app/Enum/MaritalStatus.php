<?php

namespace App\Enum;

use Filament\Support\Contracts\HasLabel;

enum MaritalStatus: string implements HasLabel
{
    case Single = 'single';
    case Engaged = 'engaged';
    case Married = 'married';
    case Other = 'other';

    public function getLabel(): ?string
    {
        return __('enum'.'.'.$this->value);
    }
}
