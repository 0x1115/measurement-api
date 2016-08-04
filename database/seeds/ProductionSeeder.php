<?php

use Illuminate\Database\Seeder;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = str_random(10);
        $user = App\User::create([
            'name' => 'Developer',
            'email' => 'dev@app.dev',
            'remember_token' => str_random(10),
            'password' => app('hash')->make($password)
        ]);
        $this->command->info("User created: <bg=yellow;options=bold;fg=black> {$user->email}/{$password} </bg=yellow;options=bold;fg=black>");

        $this->command->info("API token: <bg=yellow;options=bold;fg=black> php artisan user:token {$user->id} </bg=yellow;options=bold;fg=black>");
    }
}
