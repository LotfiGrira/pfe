<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
         [
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => 'password',
            'role' => 'admin',

         ],
         [
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => 'password2',
            'role' => 'user',
         ]
         ];
        foreach ($users as $user) {
            $created_user = User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
            ]);
            
            $created_user->assignRole($user['role']);
        }
        }
        }

      