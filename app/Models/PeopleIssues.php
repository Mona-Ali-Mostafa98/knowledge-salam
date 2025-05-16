<?php

namespace App\Models;

use App\Enum\ConstantsTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PeopleIssues extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function sector(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'sector_id', 'id')
            ->where('type', ConstantsTypes::Sectors->value);
    }

    public function saudi_direction(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'saudi_direction_id', 'id')
            ->where('type', ConstantsTypes::SaudiIssueDirection->value);
    }
}
