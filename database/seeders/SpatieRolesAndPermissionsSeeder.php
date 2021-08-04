<?php

namespace Database\Seeders;

use Database\Seeders\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class SpatieRolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $this->seedFromSimpleArray(config('groups.roles'), Role::class);
        $this->seedFromSimpleArray(config('groups.permissions'), Permission::class);
    }

    public function seedFromSimpleArray($items, $modelClass)
    {
        Model::unguard();
        foreach ($items as $slug => $id) {
            $name = $slug;
            $modelClass::updateOrCreate(
                ['id' => $id],
                [
                    'id' => $id,
                    'name' => $name,
                    'scope' => 'group'
                ]
            );
        }
        Model::reguard();

        $perms = Permission::all();
        Role::findByName('coordinator')->syncPermissions($perms);
    }
}
