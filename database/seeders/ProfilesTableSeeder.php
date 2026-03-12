<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfilesTableSeeder extends Seeder
{
    public function run(): void
    {
        $profiles = [
            [
                'id' => 1,
                'user_id' => 1,
                'avatar' => null,
                'post_code' => '100-0001',
                'address' => '東京都千代田区千代田1-1',
                'building' => '皇居前ビル101',
            ],
            [
                'id' => 2,
                'user_id' => 2,
                'avatar' => null,
                'post_code' => '530-0001',
                'address' => '大阪府大阪市北区梅田1-1-1',
                'building' => '梅田タワー202',
            ],
            [
                'id' => 3,
                'user_id' => 3,
                'avatar' => null,
                'post_code' => '810-0001',
                'address' => '福岡県福岡市中央区天神1-1',
                'building' => '天神プラザ303',
            ],
        ];

        foreach($profiles as $profile) {
            DB::table('profiles')->insert($profile);
        }
    }
}