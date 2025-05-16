<?php

namespace App\Models;

use App\Enum\ConstantsTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PeopleOrientation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function parties(): BelongsTo
    {
        return $this->belongsTo(Partie::class, 'parties_id', 'id');
    }

    public function orientation(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'orientation_id', 'id')
            ->where('type', ConstantsTypes::PoliticalOrientation->value);
    }

    public function commitment(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'commitment_id', 'id')
            ->where('type', ConstantsTypes::Commitment->value);
    }
}
