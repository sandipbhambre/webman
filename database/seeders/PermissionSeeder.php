<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // USER
        Permission::create(['name' => 'CREATE_USER', 'operation' => 'CREATE', 'model' => 'USER']);
        Permission::create(['name' => 'READ_USER', 'operation' => 'READ', 'model' => 'USER']);
        Permission::create(['name' => 'UPDATE_USER', 'operation' => 'UPDATE', 'model' => 'USER']);
        Permission::create(['name' => 'DELETE_USER', 'operation' => 'DELETE', 'model' => 'USER']);
        Permission::create(['name' => 'IMPORT_USER', 'operation' => 'IMPORT', 'model' => 'USER']);
        Permission::create(['name' => 'EXPORT_USER', 'operation' => 'EXPORT', 'model' => 'USER']);
        Permission::create(['name' => 'BULK_UPDATE_USER', 'operation' => 'BULK_UPDATE', 'model' => 'USER']);
        Permission::create(['name' => 'BULK_DELETE_USER', 'operation' => 'BULK_DELETE', 'model' => 'USER']);

        // ROLE
        Permission::create(['name' => 'CREATE_ROLE', 'operation' => 'CREATE', 'model' => 'ROLE']);
        Permission::create(['name' => 'READ_ROLE', 'operation' => 'READ', 'model' => 'ROLE']);
        Permission::create(['name' => 'UPDATE_ROLE', 'operation' => 'UPDATE', 'model' => 'ROLE']);
        Permission::create(['name' => 'DELETE_ROLE', 'operation' => 'DELETE', 'model' => 'ROLE']);
        Permission::create(['name' => 'IMPORT_ROLE', 'operation' => 'IMPORT', 'model' => 'ROLE']);
        Permission::create(['name' => 'EXPORT_ROLE', 'operation' => 'EXPORT', 'model' => 'ROLE']);
        Permission::create(['name' => 'BULK_UPDATE_ROLE', 'operation' => 'BULK_UPDATE', 'model' => 'ROLE']);
        Permission::create(['name' => 'BULK_DELETE_ROLE', 'operation' => 'BULK_DELETE', 'model' => 'ROLE']);

        // PERMISSION
        Permission::create(['name' => 'CREATE_PERMISSION', 'operation' => 'CREATE', 'model' => 'PERMISSION']);
        Permission::create(['name' => 'READ_PERMISSION', 'operation' => 'READ', 'model' => 'PERMISSION']);
        Permission::create(['name' => 'UPDATE_PERMISSION', 'operation' => 'UPDATE', 'model' => 'PERMISSION']);
        Permission::create(['name' => 'DELETE_PERMISSION', 'operation' => 'DELETE', 'model' => 'PERMISSION']);
        Permission::create(['name' => 'IMPORT_PERMISSION', 'operation' => 'IMPORT', 'model' => 'PERMISSION']);
        Permission::create(['name' => 'EXPORT_PERMISSION', 'operation' => 'EXPORT', 'model' => 'PERMISSION']);
        Permission::create(['name' => 'BULK_UPDATE_PERMISSION', 'operation' => 'BULK_UPDATE', 'model' => 'PERMISSION']);
        Permission::create(['name' => 'BULK_DELETE_PERMISSION', 'operation' => 'BULK_DELETE', 'model' => 'PERMISSION']);

        // MENU
        Permission::create(['name' => 'CREATE_MENU', 'operation' => 'CREATE', 'model' => 'MENU']);
        Permission::create(['name' => 'READ_MENU', 'operation' => 'READ', 'model' => 'MENU']);
        Permission::create(['name' => 'UPDATE_MENU', 'operation' => 'UPDATE', 'model' => 'MENU']);
        Permission::create(['name' => 'DELETE_MENU', 'operation' => 'DELETE', 'model' => 'MENU']);
        Permission::create(['name' => 'IMPORT_MENU', 'operation' => 'IMPORT', 'model' => 'MENU']);
        Permission::create(['name' => 'EXPORT_MENU', 'operation' => 'EXPORT', 'model' => 'MENU']);
        Permission::create(['name' => 'BULK_UPDATE_MENU', 'operation' => 'BULK_UPDATE', 'model' => 'MENU']);
        Permission::create(['name' => 'BULK_DELETE_MENU', 'operation' => 'BULK_DELETE', 'model' => 'MENU']);

        Permission::create(['name' => 'READ_AUTH_LOG', 'operation' => 'READ', 'model' => 'AUTH_LOG', 'is_crud' => false]);
        Permission::create(['name' => 'READ_APP_LOG', 'operation' => 'READ', 'model' => 'APP_LOG', 'is_crud' => false]);
    }
}
