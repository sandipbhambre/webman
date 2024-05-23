<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superUser = Role::create(['name' => 'SUPER USER']);
        $superAdmin = Role::create(['name' => 'SUPER ADMIN']);
        $admin = Role::create(['name' => 'ADMIN']);
        $manager = Role::create(['name' => 'MANAGER']);
        $executive = Role::create(['name' => 'EXECUTIVE']);

        $superAdmin->givePermissionTo(([
            'CREATE_USER',
            'READ_USER',
            'UPDATE_USER',
            'DELETE_USER',
            'IMPORT_USER',
            'EXPORT_USER',
            'BULK_UPDATE_USER',
            'BULK_DELETE_USER',

            'CREATE_ROLE',
            'READ_ROLE',
            'UPDATE_ROLE',
            'DELETE_ROLE',
            'IMPORT_ROLE',
            'EXPORT_ROLE',
            'BULK_UPDATE_ROLE',
            'BULK_DELETE_ROLE',

            'READ_PERMISSION',
        ]));

        $admin->givePermissionTo(([
            'CREATE_USER',
            'READ_USER',
            'UPDATE_USER',
            'DELETE_USER',
            'IMPORT_USER',
            'EXPORT_USER',
            'BULK_UPDATE_USER',
            'BULK_DELETE_USER',

            'READ_ROLE',

            'READ_PERMISSION',
        ]));

        $manager->givePermissionTo(([
            'CREATE_USER',
            'READ_USER',
            'UPDATE_USER',
            'DELETE_USER',

            'READ_ROLE',

            'READ_PERMISSION',
        ]));

        $executive->givePermissionTo(([
            'READ_USER',
        ]));
    }
}
