<?php

namespace App\Models;

use App\Enum\ConstantsTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PeopleSocial extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function statuses(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'status_id', 'id')
            ->where('type', ConstantsTypes::SocialStatuses->value);
    }

    public function types(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'type_id', 'id')
            ->where('type', ConstantsTypes::SocialTypes->value);
    }

    public function influenceLevel(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'influence_level_id', 'id')
            ->where('type', ConstantsTypes::InfluenceLevels->value);
    }
}
