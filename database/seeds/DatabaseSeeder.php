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
        if (app()->environment('production')) {
            return $this->call(ProductionSeeder::class);
        }

        $users = factory(App\User::class, 5)->create()->each(function ($user) {
            $devices = factory(App\Device::class, 10)->create()->each(function ($device) use ($user) {
                $user->devices()->save($device);
                $user->tokens()->save(factory(App\Token::class)->make());
                $device->measurements()->saveMany(factory(App\Measurement::class, 20)->make());
            });
        });
    }
}
