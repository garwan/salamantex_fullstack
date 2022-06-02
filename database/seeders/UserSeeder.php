<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')
            ->insert(
                [
                    'name' => "User 1",
                    'email' => 'user1@garwan.com',
                    'max_transactions_allowed' => 1165413,
                    'description' => 'description of user 1',
                    'password' => Hash::make('password'),
                ]
            );
        DB::table('users')->insert(
            [
                'name' => "User 2",
                'email' => 'user2@garwan.com',
                'max_transactions_allowed' => 4865,
                'description' => 'description of user 2',
                'password' => Hash::make('password'),
            ]
        );
        DB::table('users')->insert(
            [
                'name' => "User 3",
                'email' => 'user3@garwan.com',
                'max_transactions_allowed' => 98465,
                'description' => 'description of user 3',
                'password' => Hash::make('password'),
            ]
        );
    }
}
