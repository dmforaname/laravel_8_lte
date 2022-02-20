<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'email' => 'admin@example.com',
                'role' => 'admin',
            ],
            [
                'email' => 'user@example.com',
                'role' => 'user',
            ] 
        ];

        foreach ($data as $item){

            $user = User::where('email',$item['email'])->first();
            $roleToAssign = Role::findByName($item['role']);
            $user->assignRole($roleToAssign);
        }
    }
}
