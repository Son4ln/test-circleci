<?php

namespace App\Console\Commands;

use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class MakeAdminAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make Administrator Account';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $email = $this->ask('Email address?', 'admin@crluo.com');
        $password = $this->secret('Password ?', true);

        $admin = User::firstOrNew([
            'email' => $email,
        ]);

        $admin->fill([
            'name' => 'Admin',
            'password' => Hash::make($password),
            'activated_at' => Carbon::now(),
            'enabled' => 1,
        ]);

        $admin->saveOrFail();

        $admin->assignRole('admin');
    }
}
