<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DefaultUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        //
        // create default users
        //
        $root = \App\Models\User::factory()->create([
            'name' => 'I am Root',
            'email' => 'root@example.com',
            'password' => Hash::make('isylzjko'),
        ]);
        $root->syncRoles([$root::ROLE_ROOT_USER]);

        $admin = \App\Models\User::factory()->create([
            'name' => 'I am Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('isylzjko'),
        ]);
        $admin->syncRoles([$admin::ROLE_ADMIN_USER]);

        $simple = \App\Models\User::factory()->create([
            'name' => 'I am Simple',
            'email' => 'simple@example.com',
            'password' => Hash::make('isylzjko'),
        ]);
        $simple->syncRoles([$simple::ROLE_SIMPLE_USER]);
    }
}
