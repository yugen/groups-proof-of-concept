<?php

namespace Tests\Feature\Integration;

use Tests\TestCase;
use App\Models\Group;
use App\Models\Person;
use App\Models\GroupType;
use App\Models\GroupMember;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GroupTest extends TestCase
{
    use RefreshDatabase;

    public function setup():void
    {
        parent::setup();
        $this->seed();
    }

    /**
     * @test
     */
    public function group_belongs_to_group_type()
    {
        $group = Group::factory()->create();
        $this->assertInstanceOf(GroupType::class, $group->type);
    }

    /**
     * @test
     */
    public function group_has_many_members()
    {
        $group = Group::factory()->create();
        $person = Person::factory()->create();
        $groupMember = GroupMember::factory([
            'person_id' => $person,
            'group_id' => $group
        ])->create();

        $group->refresh();
        $this->assertInstanceOf(GroupMember::class, $group->members->first());
        $this->assertEquals($groupMember->id, $group->members->first()->id);
    }
    
    /**
     * @test
     */
    public function group_belongs_to_many_people()
    {
        $group = Group::factory()->create();
        $person = Person::factory()->create();
        $groupMember = GroupMember::factory([
            'person_id' => $person,
            'group_id' => $group
        ])->create();
        $this->assertInstanceOf(Person::class, $group->people->first());
        $this->assertEquals($person->id, $group->people->first()->id);
    }
}
