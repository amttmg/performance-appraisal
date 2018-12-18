<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['title' => 'admin'],
            ['title' => 'developer'],
            ['title' => 'supervisor'],
        ];
        $users = [
            [
                'name'     => 'admin',
                'username' => 'admin',
                'email'    => 'admin@admin.com',
                'password' => bcrypt('password'),
                'role_id'  => 1,
            ],
            [
                'name'     => 'Amrit Tamang',
                'username' => 'amt.tmg@gmail.com',
                'email'    => 'amt.tmg@admin.com',
                'password' => bcrypt('password'),
                'role_id'  => 2,
            ],
            [
                'name'     => 'Dipesh Pokhrel',
                'username' => 'dip@gmail.com',
                'email'    => 'dip@admin.com',
                'password' => bcrypt('password'),
                'role_id'  => 3,
            ],
        ];
        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['title' => $role['title']],
                $role
            );
        }
        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']], $user);
        }
    }
}
