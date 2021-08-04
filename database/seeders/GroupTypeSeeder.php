<?php

namespace Database\Seeders;

use App\Models\GroupType;
use Database\Seeders\Seeder;

class GroupTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedFromConfig(config('groups.types'), GroupType::class);
    }
}
