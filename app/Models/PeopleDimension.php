<?php

namespace App\Models;

use App\Enum\ConstantsTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PeopleDimension extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function dimension(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'dimension_id', 'id')
            ->where('type', ConstantsTypes::Dimensions->value);
    }
}
