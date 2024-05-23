<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superUser = User::create([
            'name' => 'Super User',
            'gender' => 'Male',
            'email' => 'superuser@webman.test',
            'username' => 'superuser',
            'mobile_number' => null,
            'image' => null,
            'password' => 'password',
        ]);
        $superUser->assignRole('SUPER USER');

        $superAdmin = User::create([
            'name' => 'Super Admin',
            'gender' => 'Female',
            'email' => 'superadmin@webman.test',
            'username' => 'superadmin',
            'mobile_number' => null,
            'image' => null,
            'password' => 'password',
        ]);
        $superAdmin->assignRole('SUPER ADMIN');

        $admin = User::create([
            'name' => 'Admin',
            'gender' => 'Male',
            'email' => 'admin@webman.test',
            'username' => 'admin',
            'mobile_number' => null,
            'image' => null,
            'password' => 'password',
        ]);
        $admin->assignRole('ADMIN');

        $manager = User::create([
            'name' => 'Manager',
            'gender' => 'Female',
            'email' => 'manager@webman.test',
            'username' => 'manager',
            'mobile_number' => null,
            'image' => null,
            'password' => 'password',
        ]);
        $manager->assignRole('MANAGER');

        $executive = User::create([
            'name' => 'Executive',
            'gender' => 'Male',
            'email' => 'executive@webman.test',
            'username' => 'executive',
            'mobile_number' => null,
            'image' => null,
            'password' => 'password',
        ]);
        $executive->assignRole('EXECUTIVE');
    }
}
