<?php

namespace App\Models;

use App\Enum\ConstantsTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Event extends Model
{
    use HasFactory;
    use HasTranslations;
    use SoftDeletes;

    public $translatable = ['title'];

    protected $guarded = [];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function sector(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'sector_id', 'id')
            ->where('type', ConstantsTypes::Sectors->value);
    }

    public function organization_role(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'organization_role_id', 'id')
            ->where('type', ConstantsTypes::OrganizationsRoles->value);
    }

    public function saudi_direction(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'saudi_direction_id', 'id')
            ->where('type', ConstantsTypes::SaudiIssueDirection->value);
    }

    public function peoples(): BelongsToMany
    {
        return $this->belongsToMany(
            Person::class,
            'event_people',
            'event_id',
            'person_id'
        );
    }
}
