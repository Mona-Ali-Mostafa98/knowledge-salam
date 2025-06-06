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

    public $translatable = ['title', 'details'];

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

    public function saudi_direction(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'saudi_direction_id', 'id')
            ->where('type', ConstantsTypes::SaudiIssueDirection->value);
    }

    public function position_type(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'position_type_id', 'id')
            ->where('type', ConstantsTypes::PositionsTypes->value);
    }
    
    /**
     * Get all people positions on issues for this event.
     */
    public function peoplePositionsOnIssues()
    {
        return $this->hasMany(PeoplePositionOnIssueAtEvent::class, 'event_id', 'id');
    }

    /**
     * Get all related people through positions.
     */
    public function peoples()
    {
        return $this->belongsToMany(
            Person::class,
            'people_positions_on_issues_at_events',
            'event_id',
            'person_id'
        )->withPivot('issue_id', 'person_position')->withTimestamps();
    }

    /**
     * Get all related issues through positions.
     */
    public function relatedIssuesPeople()
    {
        return $this->belongsToMany(
            Issues::class,
            'people_positions_on_issues_at_events',
            'event_id',
            'issue_id'
        )->withPivot('person_id', 'person_position')->withTimestamps();
    }

    /**
     * Get all organization positions on issues for this event.
     */
    public function organizationPositionsOnIssues()
    {
        return $this->hasMany(OrganizationPositionOnIssueAtEvent::class, 'event_id', 'id');
    }
    /**
     * Get all related organizations through positions.
     */
    public function organizations()  
    {
        return $this->belongsToMany(
            Organization::class,
            'organization_positions_on_issues_at_events',
            'event_id',
            'organization_id'
        )->withPivot('issue_id', 'organization_position')->withTimestamps();
    }
    /**
     * Get all related issues through positions.
     */
    public function relatedIssuesOrganizations()    
    {
        return $this->belongsToMany(
            Issues::class,
            'organization_positions_on_issues_at_events',
            'event_id',
            'issue_id'
        )->withPivot('organization_id', 'organization_position')->withTimestamps();
    }
    public function organization_role(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'organization_role_id', 'id')
            ->where('type', ConstantsTypes::OrganizationsRoles->value);
    }
}
