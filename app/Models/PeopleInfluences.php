<?php

namespace App\Models;

use App\Enum\ConstantsTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PeopleInfluences extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function Social(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'social_id', 'id')
            ->where('type', ConstantsTypes::SocialTypes->value);
    }

    public function influence_type(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'influence_type_id', 'id')
            ->where('type', ConstantsTypes::InfluenceTypes->value);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }
}
