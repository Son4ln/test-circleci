<?php

use App\Role;
use App\Permission;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $guard = config('auth.defaults.guard');
        $now = Carbon::now()->format('Y-m-d H:i:s');

        try {
            DB::beginTransaction();

            // Reset cached roles and permissions
            Cache::forget('spatie.permission.cache');

            /**
             * Permission seed
             */
            foreach (Permission::getDefaultPermissions() as $permission => $description) {
                DB::table(config('permission.table_names.permissions'))->insert([
                    'name' => $permission,
                    'guard_name' => $guard,
                    'created_at' => $now,
                    'updated_at' => $now,
                    'description' => $description,
                ]);
            }

            // Reset cached roles and permissions
            Cache::forget('spatie.permission.cache');

            /**
             * Roles seed
             */
            foreach (Role::getDefaultRoles() as $role => $permissions) {
                DB::table(config('permission.table_names.roles'))->insert([
                    'name' => $role,
                    'guard_name' => $guard,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                Role::findByName($role)->givePermissionTo($permissions);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            $this->command->error($e->getMessage());
            $this->command->info($e->getTraceAsString());
        }
    }
}
