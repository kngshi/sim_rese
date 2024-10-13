<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
        'id' => '1',
        'name' => '管理者',
        'email' => 'admin@example.com',
        'role' => '1',
        'password' => bcrypt('admin1234'),
        ];

        DB::table('users')->insert($param);

        $param = [
            'id' => '2',
            'name' => '店舗責任者',
            'email' => 'manager@example.com',
            'role' => '2',
            'password' => bcrypt('manager1234'),
        ];

        DB::table('users')->insert($param);

        $param = [
            'id' => '3',
            'name' => 'サンプルユーザー',
            'email' => 'sample@example.com',
            'role' => '3',
            'password' => bcrypt('sample1234'),
        ];

        DB::table('users')->insert($param);

        $param = [
            'id' => '4',
            'name' => 'サンプルユーザー2',
            'email' => 'sample2@example.com',
            'role' => '3',
            'password' => bcrypt('sample1234'),
        ];

        DB::table('users')->insert($param);
    }
}
