<?php

namespace App\Models;

use App\Enum\ConstantsTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Issues extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'person_id', 'id');
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function issue_name(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'issue_name_id', 'id')
            ->where('type', ConstantsTypes::IssuesNames->value);
    }
}
