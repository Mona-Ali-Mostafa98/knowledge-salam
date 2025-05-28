<?php

namespace App\Models;

use App\Enum\ConstantsTypes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganizationPositionOnIssueAtEvent extends Model
{
    protected $table = 'organization_positions_on_issues_at_events';

    // Use guarded or fillable as preferred
    protected $guarded = [];

    public $timestamps = true;

    // Relationships
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }


    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function issue()
    {
        return $this->belongsTo(Issues::class, 'issue_id', 'id');
    }

    public function organization_role(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'organization_role_id', 'id')
            ->where('type', ConstantsTypes::OrganizationsRoles->value);
    }

    public function organization_direction(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'organization_direction_id', 'id')
            ->where('type', ConstantsTypes::SaudiIssueDirection->value);
    }
}

