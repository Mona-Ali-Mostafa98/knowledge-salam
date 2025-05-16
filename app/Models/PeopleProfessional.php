<?php

namespace App\Models;

use App\Enum\ConstantsTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PeopleProfessional extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function organization_type(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'organization_type_id', 'id')
            ->where('type', ConstantsTypes::OrganizationsTypes->value);
    }

    public function organization_level(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'organization_level_id', 'id')
            ->where('type', ConstantsTypes::OrganizationsLevels->value);
    }

    public function institution_type(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'institution_type_id', 'id')
            ->where('type', ConstantsTypes::InstitutionTypes->value);
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'position_id', 'id')
            ->where('type', ConstantsTypes::Positions->value);
    }

    public function specialization(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'specialization_id', 'id')
            ->where('type', ConstantsTypes::Specializations->value);
    }

    public function influence_level(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'influence_level_id', 'id')
            ->where('type', ConstantsTypes::InfluenceLevels->value);
    }
}
