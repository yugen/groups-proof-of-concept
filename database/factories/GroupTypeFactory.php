<?php

namespace Database\Factories;

use App\Models\GroupType;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GroupType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'abbreviation' => $this->faker->word,
            'description' => $this->faker->sentence
        ];
    }
}
