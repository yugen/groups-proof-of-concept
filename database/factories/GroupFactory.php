<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\GroupType;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Group::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word,
            'group_type_id' => ($groupType = GroupType::all()->random())
                                ? $groupType->id
                                : GroupType::factory()->create()->id,
        ];
    }
}
