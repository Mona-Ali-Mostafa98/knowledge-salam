<?php

namespace App\Models;

use App\Enum\ConstantsTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PeoplePosition extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function political_position(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'political_position_id', 'id')
            ->where('type', ConstantsTypes::PoliticalPositions->value);
    }
}
