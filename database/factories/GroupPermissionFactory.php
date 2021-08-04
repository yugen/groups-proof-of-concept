<?php

namespace Database\Factories;

use App\Models\GroupPermission;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupPermissionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GroupPermission::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word,
            'description' => $this->faker->sentence
        ];
    }
}
