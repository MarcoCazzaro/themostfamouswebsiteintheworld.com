<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use \App\Models\User;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // https://www.honeybadger.io/blog/user-roles-permissions-in-laravel/
        $gE = User::where('email', 'info@snappysnail.io')->first();
        if ($gE && !$gE->hasRole('Supremo')) {
            Permission::create(['name' => 'supadupaadminshit']);
            $adminRole = Role::create(['name' => 'Supremo']);
            $adminRole->givePermissionTo([
                'supadupaadminshit',
            ]);
            $gE->assignRole('Supremo');
        }
    }
}
