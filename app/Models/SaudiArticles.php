<?php

namespace App\Models;

use App\Enum\ConstantsTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class SaudiArticles extends Model
{
    use HasFactory;
    use HasTranslations;
    use SoftDeletes;

    public $translatable = ['title', 'contribution_name'];

    protected $guarded = [];

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'person_id', 'id');
    }

    public function sector(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'sector_id', 'id')
            ->where('type', ConstantsTypes::Sectors->value);
    }

    public function article_type(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'article_type_id', 'id')
            ->where('type', ConstantsTypes::ArticlesTypes->value);
    }

    public function source_location(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'source_location_id', 'id')
            ->where('type', ConstantsTypes::SourceLocations->value);
    }

    public function publish_institution_type(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'publish_institution_type_id', 'id')
            ->where('type', ConstantsTypes::InstitutionTypes->value);
    }

    public function organizations_role(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'organizations_role_id', 'id')
            ->where('type', ConstantsTypes::OrganizationsRoles->value);
    }

    public function contribution_role(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'contribution_role_id', 'id')
            ->where('type', ConstantsTypes::ContributionRoles->value);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'language_id', 'id')
            ->where('type', ConstantsTypes::Languages->value);
    }

    public function added_reason(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'added_reason_id', 'id')
            ->where('type', ConstantsTypes::AddedReasons->value);
    }

    public function repetition(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'repetition_id', 'id')
            ->where('type', ConstantsTypes::Repetitions->value);
    }

    public function saudi_issue_direction(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'saudi_issue_direction_id', 'id')
            ->where('type', ConstantsTypes::SaudiIssueDirection->value);
    }

    public function report_direction(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'report_direction_id', 'id')
            ->where('type', ConstantsTypes::ReportDirections->value);
    }

    public function dimension(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'dimension_id', 'id')
            ->where('type', ConstantsTypes::Dimensions->value);
    }

    public function contribution_type(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'contribution_type_id', 'id')
            ->where('type', ConstantsTypes::ContributionType->value);
    }

    public function continent(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'continent_id', 'id')
            ->where('type', ConstantsTypes::Continent->value);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    protected $casts = [
        'countries' => 'array',
        'cities' => 'array',
    ];
}
