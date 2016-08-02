<?php

namespace App\Console\Commands;

use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UserToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:token {user : The ID of the user} {--forever : Immortality} {--exp=60 : The expiration of the token in day(s) }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get an api token for a specific user';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $expiration = null;

        $user = User::find($this->argument('user'));
        if (!$user) {
            return $this->error('User does not exist');
        }

        $exp = $this->option('exp');
        if ($exp) {
            $expiration = Carbon::now()->addDays($exp);
        }
        if ($this->option('forever')) {
            $expiration = null;
        }

        $token = factory(\App\Token::class)->make()->fill(['expired_at' => $expiration]);
        $user->tokens()->save($token);
        $this->info('Your token: [' . $token->content . ']');
    }
}