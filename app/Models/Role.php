<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasFactory;

    protected $casts = [
        'scoped_to_groups' => 'boolean'
    ];

    /**
     * SCOPES
     */
    public function scopeGroup($query)
    {
        return $query->where('scope', 'group');
    }

    public function scopeSystem($query)
    {
        return $query->where('scope', 'system');
    }
}
