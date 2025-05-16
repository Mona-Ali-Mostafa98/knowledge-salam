<?php

namespace App\Models;

use App\Enum\Actions;
use App\Enum\ConstantsTypes;
use App\Enum\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Organization extends Model
{
    use HasFactory;
    use HasTranslations;
    use SoftDeletes;

    protected $guarded = [];

    public $translatable = ['name', 'boss'];

    public function socials(): HasMany
    {
        return $this->hasMany(OrganizationSocial::class, 'organization_id', 'id');
    }

    public function influences(): HasMany
    {
        return $this->hasMany(OrganizationInfluence::class, 'organization_id', 'id');
    }

    public function dimensions(): HasMany
    {
        return $this->hasMany(OrganizationDimension::class, 'organization_id', 'id');
    }

    public function people(): HasMany
    {
        return $this->hasMany(OrganizationPeople::class, 'organization_id', 'id');
    }

    public function organization_status(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'status_id', 'id')
            ->where('type', ConstantsTypes::OrganizationsStatuses->value);
    }

    public function organization_type(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'type_id', 'id')
            ->where('type', ConstantsTypes::OrganizationsTypes->value);
    }

    public function continent(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'continent_id', 'id')
            ->where('type', ConstantsTypes::Continent->value);
    }

    public function organization_level(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'organization_level_id', 'id')
            ->where('type', ConstantsTypes::OrganizationsLevels->value);
    }

    public function money_resource(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'money_resource_id', 'id')
            ->where('type', ConstantsTypes::MoneyResources->value);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(Logs::class, 'model_id', 'id')
            ->where('model', Models::Organization->value)
            ->where('action', Actions::Review->value);
    }
}
