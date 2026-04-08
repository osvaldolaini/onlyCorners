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
        DB::table('users')->insert([
            'name'              => 'super_admin',
            'active'            => '1',
            'panel'             => 'admin',
            'dark'              => 1,
            'see_excluded'      => 0,
            'activities'        => json_encode([
                'create',
                'delete',
                'update',
                'active'
            ]),
            'groups'            => json_encode([
                'admin',
                'user'
            ]),
            'accesses'            => json_encode([
                'all'
            ]),
            'email'             => 'admin@admin.com',
            'password'          => Hash::make('123456789'),
            'active'            => 1,
        ]);
    }
}
