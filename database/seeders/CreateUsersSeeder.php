<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
                $user = [

            [

               'name'=>'Admin',

               'email'=>'admin@resoluteadmin.com',

               'userType'=>'admin',

               'password'=> bcrypt('123456'),

            ],

            [

               'name'=>'User',

               'email'=>'user@resoluteuser.com',

               'userType'=>'user',

               'password'=> bcrypt('123456'),

            ],

            [

               'name'=>'Vendor',

               'email'=>'vendor@resolutevendor.com',

               'userType'=>'vendor',

               'password'=> bcrypt('123456'),

            ],

        ];

  

        foreach ($user as $key => $value) {

            User::create($value);

        }
    }
}
