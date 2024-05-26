<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::create([
            "title" => "Dashboard",
            "sub_title" => null,
            "icon" => "fas fa-tachometer-alt",
            "sub_icon" => null,
            "order" => 1,
            "sub_order" => null,
            "route" => "dashboard",
            "permissions" => null,
        ]);

        Menu::create([
            "title" => "System Manager",
            "sub_title" => "Users",
            "icon" => "fas fa-toolbox",
            "sub_icon" => "fas fa-users",
            "order" => 2,
            "sub_order" => 1,
            "route" => "users.index",
            "permissions" => "READ_USER",
        ]);

        Menu::create([
            "title" => "System Manager",
            "sub_title" => "Roles",
            "icon" => "fas fa-toolbox",
            "sub_icon" => "fas fa-user-tag",
            "order" => 2,
            "sub_order" => 2,
            "route" => "roles.index",
            "permissions" => "READ_ROLE",
        ]);

        Menu::create([
            "title" => "System Manager",
            "sub_title" => "Permissions",
            "icon" => "fas fa-toolbox",
            "sub_icon" => "fas fa-user-cog",
            "order" => 2,
            "sub_order" => 3,
            "route" => "permissions.index",
            "permissions" => "READ_PERMISSION",
        ]);

        Menu::create([
            "title" => "System Manager",
            "sub_title" => "Menus",
            "icon" => "fas fa-toolbox",
            "sub_icon" => "fas fa-server",
            "order" => 2,
            "sub_order" => 4,
            "route" => "menus.index",
            "permissions" => "READ_MENU",
        ]);

        Menu::create([
            "title" => "Logs",
            "sub_title" => "App Logs",
            "icon" => "fas fa-clipboard-list",
            "sub_icon" => "fas fa-clipboard-check",
            "order" => 3,
            "sub_order" => 1,
            "route" => "app-logs.index",
            "permissions" => "READ_APP_LOG",
        ]);

        Menu::create([
            "title" => "Logs",
            "sub_title" => "Auth Logs",
            "icon" => "fas fa-clipboard-list",
            "sub_icon" => "fas fa-clipboard-check",
            "order" => 3,
            "sub_order" => 2,
            "route" => "auth-logs.index",
            "permissions" => "READ_AUTH_LOG",
        ]);
    }
}
