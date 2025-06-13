<?php

namespace App\Models;

use App\Enum\ConstantsTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Issues extends Model
{
    use HasFactory;
    use HasTranslations;
    use SoftDeletes;

    protected $guarded = [];

    public $translatable = ['issue_name'];

    public function issueType(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'issue_type', 'id')
            ->where('type', ConstantsTypes::IssuesTypes->value);
    }

    public function issueField(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'issue_field', 'id')
            ->where('type', ConstantsTypes::PositionsTypes->value);
    }
}
