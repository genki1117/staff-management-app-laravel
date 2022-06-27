<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            [
                'name' => 'admin_test1',
                'age' => 33,
                'email' => 'admin_test1@test.com',
                'department_id' => 1,
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'admin_test2',
                'age' => 43,
                'email' => 'admin_test2@test.com',
                'department_id' => 2,
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'admin_test3',
                'age' => 23,
                'email' => 'admin_test3@test.com',
                'department_id' => 3,
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'admin_test4',
                'age' => 66,
                'email' => 'admin_test4@test.com',
                'department_id' => 1,
                'password' => Hash::make('password123')
            ],
                [
                    'name' => 'admin_test5',
                    'age' => 66,
                    'email' => 'admin_test5@test.com',
                    'department_id' => 1,
                    'password' => Hash::make('password123')
                ]
        ]
        );
    }
}
