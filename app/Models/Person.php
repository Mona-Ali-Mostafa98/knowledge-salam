<?php

namespace App\Models;

use App\Enum\Actions;
use App\Enum\ConstantsTypes;
use App\Enum\MaritalStatus;
use App\Enum\Models;
use App\Enum\PersonActivity;
use App\Enum\PersonStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Person extends Model
{
    use HasFactory;
    use HasTranslations;
    use SoftDeletes;

    public $translatable = ['first_name', 'mid_name', 'last_name'];

    protected $appends = ['name'];

    protected $guarded = [];

    public function nationality(): BelongsTo
    {
        return $this->belongsTo(Nationality::class, 'nationality_id', 'id');
    }

    public function birth_country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'birth_country_id', 'id');
    }

    public function birth_city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'birth_city_id', 'id');
    }

    public function religion(): BelongsTo
    {
        return $this->belongsTo(Religion::class, 'religion_id', 'id');
    }

    public function sect(): BelongsTo
    {
        return $this->belongsTo(Sect::class, 'sect_id', 'id');
    }

    public function religiosity(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'nationality_id', 'id')
            ->where('type', ConstantsTypes::Religiosity->value);
    }

    public function fameReason(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'fame_reasons_id', 'id')
            ->where('type', ConstantsTypes::FameReasons->value);
    }

    protected function statusTranslated(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->status ? PersonActivity::tryFrom($this->status)->getLabel() : $this->status,
        );
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->first_name.' '.$this->mid_name.' '.$this->last_name,
        );
    }

    protected function maritalStatusTranslated(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->marital_status ? MaritalStatus::tryFrom($this->marital_status)->getLabel() : $this->marital_status,
        );
    }

    protected function personStatusTranslated(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->person_status ? PersonStatus::tryFrom($this->person_status)->getLabel() : $this->person_status,
        );
    }

    public function professionals(): HasMany
    {
        return $this->hasMany(PeopleProfessional::class, 'person_id', 'id');
    }

    public function socials(): HasMany
    {
        return $this->hasMany(PeopleSocial::class, 'person_id', 'id');
    }

    public function orientations(): HasMany
    {
        return $this->hasMany(PeopleOrientation::class, 'person_id', 'id');
    }

    public function dimensions(): HasMany
    {
        return $this->hasMany(PeopleDimension::class, 'person_id', 'id');
    }

    public function facts(): HasMany
    {
        return $this->hasMany(PeopleFact::class, 'person_id', 'id');
    }

    public function experiences(): HasMany
    {
        return $this->hasMany(PeopleExperience::class, 'person_id', 'id');
    }

    public function videos(): HasMany
    {
        return $this->hasMany(Videos::class, 'person_id', 'id');
    }

    public function articles(): HasMany
    {
        return $this->hasMany(SaudiArticles::class, 'person_id', 'id');
    }

    public function positions(): HasMany
    {
        return $this->hasMany(SaudiPositions::class, 'person_id', 'id');
    }

    public function influences(): HasMany
    {
        return $this->hasMany(PeopleInfluences::class, 'person_id', 'id');
    }

    public function issues(): HasMany
    {
        return $this->hasMany(PeopleIssues::class, 'person_id', 'id');
    }

    public function people_positions(): HasMany
    {
        return $this->hasMany(PeoplePosition::class, 'person_id', 'id');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(Logs::class, 'model_id', 'id')
            ->where('model', Models::Person->value)
            ->where('action', Actions::Review->value);
    }
}
