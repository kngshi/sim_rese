<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewsTableSeeder extends Seeder
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
            'user_id' => '3',
            'shop_id' => '1',
            'rating' => '5',
            'comment' => 'テストコメント（仙人）byサンプルユーザー',
        ];
        DB::table('reviews')->insert($param);

        $param = [
            'id' => '2',
            'user_id' => '3',
            'shop_id' => '2',
            'rating' => '4',
            'comment' => 'テストコメント（牛助）byサンプルユーザー',
        ];
        DB::table('reviews')->insert($param);

        $param = [
            'id' => '3',
            'user_id' => '4',
            'shop_id' => '1',
            'rating' => '3',
            'comment' => 'テストコメント（仙人）byサンプルユーザー2',
        ];
        DB::table('reviews')->insert($param);

        $param = [
            'id' => '4',
            'user_id' => '4',
            'shop_id' => '2',
            'rating' => '3',
            'comment' => 'テストコメント（牛助）byサンプルユーザー2',
        ];
        DB::table('reviews')->insert($param);

        $param = [
            'id' => '5',
            'user_id' => '4',
            'shop_id' => '3',
            'rating' => '3',
            'comment' => 'テストコメント（戦慄）byサンプルユーザー',
        ];
        DB::table('reviews')->insert($param);

        $param = [
            'id' => '6',
            'user_id' => '3',
            'shop_id' => '4',
            'rating' => '5',
            'comment' => 'テストコメント（ルーク）byサンプルユーザー',
        ];
        DB::table('reviews')->insert($param);
    }
}
