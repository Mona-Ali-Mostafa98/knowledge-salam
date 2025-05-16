<?php

namespace App\Models;

use App\Enum\ConstantsTypes;
use App\Enum\Qualification;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PeopleExperience extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function specialization(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'specializations_id', 'id')
            ->where('type', 'specializations');
    }

    public function influence_level(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'influence_id', 'id')
            ->where('type', ConstantsTypes::InfluenceLevels->value);
    }

    protected function qualificationTranslated(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->qualification ? Qualification::tryFrom($this->qualification)->getLabel() : $this->qualification,
        );
    }
}
