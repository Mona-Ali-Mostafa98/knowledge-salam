<?php

namespace App\Models;

use App\Enum\ConstantsTypes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Constant extends Model
{
    use HasFactory;
    use HasTranslations;
    use SoftDeletes;

    public $translatable = ['name'];

    protected $guarded = [];

    protected function typeTranslated(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->type ? ConstantsTypes::tryFrom($this->type)->getLabel() : $this->type,
        );
    }
}
