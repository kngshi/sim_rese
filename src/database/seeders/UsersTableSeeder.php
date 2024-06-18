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
    }
}
