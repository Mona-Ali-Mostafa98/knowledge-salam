<?php

namespace App\Models;

use App\Enum\ConstantsTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganizationPeople extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'person_id', 'id');
    }

    public function organizations_role(): BelongsTo
    {
        return $this->belongsTo(Constant::class, 'role_id', 'id')
            ->where('type', ConstantsTypes::OrganizationsInRoles->value);
    }
}
