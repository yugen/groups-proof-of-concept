<?php

namespace Tests\Feature\Integration;

use Tests\TestCase;
use App\Models\Role;
use App\Models\Permission;
use App\Models\GroupMember;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GroupMemberTest extends TestCase
{
    use RefreshDatabase;

    public function setup():void
    {
        parent::setup();
        $this->seed();
        $this->groupMember = GroupMember::factory()->create();
    }
    
    /**
     * @test
     */
    public function group_member_belongs_to_many_roles_and_permissions()
    {
        $this->groupMember->assignRole('coordinator');

        $this->assertTrue($this->groupMember->hasRole('coordinator'));
        $this->assertTrue($this->groupMember->hasPermissionTo('info-edit'));
        $this->assertTrue($this->groupMember->hasPermissionTo('members-invite'));
        $this->assertTrue($this->groupMember->hasPermissionTo('members-remove'));
    }

    /**
     * @test
     */
    public function throws_exception_when_trying_assign_a_system_role()
    {
        $systemRole = Role::create(['name' => 'blah-can', 'scope'=> 'system']);
        $this->expectExceptionCode(422);
        $this->groupMember->assignRole($systemRole);
    }

    /**
     * @test
     */
    public function can_grant_permission_when_scope_matches()
    {
        $groupPerm = Permission::create(['name' => 'run group', 'scope' => 'group']);
        $systemPerm = Permission::create(['name' => 'run system', 'scope' => 'system']);
        
        $this->groupMember->givePermissionTo('run group');
        $this->assertTrue($this->groupMember->hasPermissionTo('run group'));

        $this->expectExceptionCode(422);
        $this->groupMember->givePermissionTo('run system');
    }
}
