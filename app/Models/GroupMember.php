<?php

namespace App\Models;

use App\Models\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HasGroupRolesAndPermissions;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Contracts\Auth\Access\Authorizable as AccessAuthorizable;

class GroupMember extends Model implements AccessAuthorizable
{
    use HasFactory;
    use SoftDeletes;
    use HasRoles;
    use Authorizable;

    protected $permissionScope = 'group';
    protected $guard_name = 'web';
    public $fillable = [
        'group_id',
        'person_id',
        'start_date',
        'end_date',
    ];

    public $dates = [
        'start_date',
        'end_date'
    ];

    /**
     * RELATIONS
     */

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(People::class, 'person_id', 'id');
    }
}
