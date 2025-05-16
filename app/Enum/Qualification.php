<?php

namespace App\Enum;

use Filament\Support\Contracts\HasLabel;

enum Qualification: string implements HasLabel
{
    case Secondary = 'secondary';
    case HighSchool = 'high_school';
    case Diploma = 'diploma';
    case Bachelor = 'bachelor';
    case Master = 'master';
    case Doctorate = 'doctorate';
    case Professor = 'professor';
    case Other = 'other';

    public function getLabel(): ?string
    {
        return __('enum'.'.'.$this->value);
    }
}
