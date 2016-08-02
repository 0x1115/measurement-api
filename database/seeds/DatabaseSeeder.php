<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $devices = factory(App\Device::class, 10)->create()->each(function ($device) {
            $device->tokens()->save(factory(App\Token::class)->make());
            $device->measurements()->saveMany(factory(App\Measurement::class, 20)->make());
        });
    }
}
