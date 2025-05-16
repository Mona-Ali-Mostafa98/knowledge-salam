<?php

namespace App\Enum;

use Filament\Support\Contracts\HasLabel;

enum Actions: string implements HasLabel
{
    case Create = 'create';
    case Update = 'update';
    case Delete = 'delete';
    case Review = 'review';

    public function getLabel(): ?string
    {
        return __('enum'.'.'.$this->value);
    }
}
