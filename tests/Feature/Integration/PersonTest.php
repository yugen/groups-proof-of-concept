<?php

namespace Tests\Feature\Integration;

use Tests\TestCase;
use App\Models\Group;
use App\Models\Person;
use App\Models\GroupMember;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PersonTest extends TestCase
{
    use RefreshDatabase;
    
    public function setup():void
    {
        parent::setup();
        $this->seed();

        $this->group = Group::factory()->create();
        $this->person = Person::factory()->create();
        $this->groupMember = GroupMember::factory([
            'person_id' => $this->person,
            'group_id' => $this->group
        ])->create();
    }

    /**
     * @test
     */
    public function has_many_memberships()
    {
        $this->assertInstanceOf(GroupMember::class, $this->person->memberships->first());
        $this->assertEquals($this->groupMember->id, $this->person->memberships->first()->id);
    }

    /**
     * @test
     */
    public function has_many_groups()
    {
        $this->assertInstanceOf(Group::class, $this->person->groups->first());
        $this->assertEquals($this->group->id, $this->person->groups->first()->id);
    }
}
