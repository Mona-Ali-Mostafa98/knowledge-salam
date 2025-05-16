<?php

namespace App\Models;

use App\Enum\ConstantsTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Videos extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'person_id', 'id');
    }

    public function direction(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'direction_id', 'id')
            ->where('type', ConstantsTypes::SaudiDirection->value);
    }

    public function position_type(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'position_type_id', 'id')
            ->where('type', ConstantsTypes::PositionsTypes->value);
    }
}
