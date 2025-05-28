<?php

namespace App\Models;
use App\Enum\ConstantsTypes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PeoplePositionOnIssueAtEvent extends Model
{
    protected $table = 'people_positions_on_issues_at_events';

    // Optional: if using guarded instead of fillable
    protected $guarded = [];

    public $timestamps = true;

    // Relations
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id', 'id');
    }

    public function issue()
    {
        return $this->belongsTo(Issues::class, 'issue_id', 'id');
    }

    public function person_direction(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'person_direction_id', 'id')
            ->where('type', ConstantsTypes::SaudiIssueDirection->value);
    }
}

