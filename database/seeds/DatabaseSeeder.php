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
            return $this->runProduction();
        }

        $users = factory(App\User::class, 5)->create()->each(function ($user) {
            $devices = factory(App\Device::class, 10)->create()->each(function ($device) use ($user) {
                $user->devices()->save($device);
                $user->tokens()->save(factory(App\Token::class)->make());
                $device->measurements()->saveMany(factory(App\Measurement::class, 20)->make());
            });
        });
    }

    public function runProduction()
    {
        $password = str_random(10);
        $user = factory(App\User::class, 'production')->create();
        $user->update([
            'password' => app('hash')->make($password)
        ]);
        $this->command->info("User created: <bg=yellow;options=bold;fg=black> {$user->email}/{$password} </bg=yellow;options=bold;fg=black>");

        $this->command->info("API token: <bg=yellow;options=bold;fg=black> php artisan user:token {$user->id} </bg=yellow;options=bold;fg=black>");
    }
}
