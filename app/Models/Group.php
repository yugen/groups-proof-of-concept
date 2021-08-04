<?php

namespace App\Models;

use App\Models\GroupType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Group extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $fillable = [
        'name',
        'group_type_id',
    ];

    /**
     * RELATIONS
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(GroupType::class, 'group_type_id', 'id');
    }

    /**
     * Get all of the members for the Group
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function members(): HasMany
    {
        return $this->hasMany(GroupMember::class);
    }

    /**
     * The people that belong to the Group
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function people(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'group_members', 'group_id', 'person_id');
    }
}
