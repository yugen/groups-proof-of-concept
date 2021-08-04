<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Person extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $fillable = [
        'first_name',
        'last_name',
        'email'
    ];

    /**
     * RELATIONS
     */
    public function memberships(): HasMany
    {
        return $this->hasMany(GroupMember::class, 'person_id', 'id');
    }

    /**
     * Get all of the groups for the Person
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'group_members', 'person_id', 'group_id')
                    ->withPivot(['start_date', 'end_date']);
    }
}
