<?php

namespace Tests\Feature\Integration;

use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    
    public function setup():void
    {
        parent::setup();
        $this->seed();
    }

    /**
     * @test
     */
    public function can_get_only_group_roles()
    {
        $groupRole = Role::create(['name' => $this->faker->word, 'scope' => 'group']);
        $systemRole = Role::create(['name' => $this->faker->word, 'scope'=> 'system']);

        $groupRoleIds =  Role::group()->get()->pluck('id')->toArray();

        $this->assertNotContains($systemRole->id, $groupRoleIds);
        $this->assertContains($groupRole->id, $groupRoleIds);
    }

    /**
     * @test
     */
    public function can_get_only_system_roles()
    {
        $groupRole = Role::create(['name' => $this->faker->word, 'scope' => 'group']);
        $systemRole = Role::create(['name' => $this->faker->word, 'scope'=> 'system']);

        $systemRoleIds = Role::system()->get()->pluck('id')->toArray();
        $this->assertNotContains($groupRole->id, $systemRoleIds);
        $this->assertContains($systemRole->id, $systemRoleIds);
    }
}
