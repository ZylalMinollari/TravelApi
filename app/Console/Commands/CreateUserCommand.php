<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command create a new user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user['name'] = $this->ask('What will be user name');
        $user['email'] = $this->ask('What will be  user email');
        $user['password'] = $this->secret('What will be  user password');
        $roleName = $this->choice('Role of the user', ['admin', 'editor'], 1);

        $validator = Validator::make([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:'. User::class],
            'password' => ['required', Password::default()],
        ]);

        if($validator->fails()){
            foreach ($validator->errors()->all() as $erorr) {
                $this->error($erorr);
            }
            return;
        }

        $role = Role::where('name', $roleName)->first();
        if(!$role) {
            $this->error('Role Not Found');

            return;
        }

        DB::transaction(function () use ($user, $role){
            $newUser = User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => bcrypt($user['password']),
            ]);
            $newUser->role()->attach($role->id);
        });

    }
}
