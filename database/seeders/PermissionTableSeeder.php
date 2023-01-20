<?php

namespace Database\Seeders;

use App\Models\User;
use App\Traits\SysPermissions;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    use SysPermissions;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->permissions() as $permission) {
            try {
                Permission::create([
                    'guard_name' => 'web',
                    'name' => Str::slug($permission)
                ]);

                // ASSIGN TO USERS
                $admin = User::query()->oldest('created_at')->first();
                $admin->givePermissionTo(Str::slug($permission));
            } catch (Exception $exception) {
                Log::error($exception->getMessage());
                continue;
            }
        }
    }
}
