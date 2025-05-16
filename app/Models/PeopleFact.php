<?php

namespace App\Models;

use App\Enum\ConstantsTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PeopleFact extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function achievement(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'achievement_id', 'id')
            ->where('type', ConstantsTypes::Achievements->value);
    }
}
