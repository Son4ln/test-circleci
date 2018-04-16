<?php
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::beginTransaction();

            $this->createAdmin();
            $this->createCreator();
            $this->createClient();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            $this->command->error($e->getMessage());
            $this->command->info($e->getTraceAsString());
        }
    }

    /**
     * Create admin account
     */
    protected function createAdmin()
    {
        /** @var \App\User $admin */
        $admin = User::create([
            'name' => 'テスト管理者',
            'email' => 'admin@gyaku.info',
            'password' => Hash::make('aaaaaa'),
            'enabled' => 1,
            'activated_at' => Carbon::parse('1977/01/01'),
        ]);

        $admin->assignRole('admin');
    }

    /**
     * Create creator account
     */
    protected function createCreator()
    {
        /** @var \App\User $admin */
        $admin = User::create([
            'name' => 'テストクリエイター',
            'email' => 'creator@gyaku.info',
            'password' => Hash::make('aaaaaa'),
            'enabled' => 1,
            'activated_at' => Carbon::parse('1977/01/01'),
        ]);

        $admin->assignRole('creator');
    }

    /**
     * Create client account
     */
    protected function createClient()
    {
        /** @var \App\User $admin */
        $admin = User::create([
            'name' => 'テストクライアント',
            'email' => 'client@gyaku.info',
            'password' => Hash::make('aaaaaa'),
            'enabled' => 1,
            'activated_at' => Carbon::parse('1977/01/01'),
        ]);

        $admin->assignRole('client');
    }
}
