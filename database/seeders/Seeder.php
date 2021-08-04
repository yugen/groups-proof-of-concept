<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder as BaseSeeder;

abstract class Seeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    abstract public function run();

    public function seedFromConfig($config, $modelClass)
    {
        Model::unguard();
        $items = $config;
        if (is_string($config)) {
            $items = config($config);
        }
        foreach ($items as $slug => $value) {
            if (is_integer($value)) {
                $modelClass::updateOrCreate([
                  'id' => $value,
                  'name' => ucfirst(preg_replace('/-/', ' ', $slug)),
                ]);
            }

            if (is_array($value)) {
                $modelClass::updateOrCreate(['id' => $value['id']], $value);
            }
        }
        Model::reguard();
    }

    public function seedFromArray($items, $modelClass)
    {
        Model::unguard();
        foreach ($items as $itemData) {
            $modelClass::updateOrCreate(['id'=>$itemData['id']], $itemData);
        }
        Model::reguard();
    }

    public function seedFromSimpleArray($items, $modelClass)
    {
        Model::unguard();
        foreach ($items as $slug => $id) {
            $name = Str::title($slug);
            $modelClass::updateOrCreate(['id' => $id, 'name' => $name]);
        }
        Model::reguard();
    }
}
