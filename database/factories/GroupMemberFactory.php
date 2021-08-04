<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\Person;
use App\Models\GroupMember;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupMemberFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GroupMember::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'person_id' => $this->randomOrCreate(Person::class)->id,
            'group_id' => $this->randomOrCreate(Group::class)->id,
            'start_date' => $this->faker->dateTimeBetween('-5 years', 'now'),
            'end_date' => $this->faker->randomElement([$this->faker->dateTimeBetween('-4 years', 'now'), null])
        ];
    }

    private function randomOrCreate($modelClass)
    {
        $models = $modelClass::all();
        if ($models->count() > 0) {
            return $models->random();
        }

        return $modelClass::factory()->create();
    }
}
