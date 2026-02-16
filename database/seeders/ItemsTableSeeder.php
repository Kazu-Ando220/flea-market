<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'id' => 1,
                'user_id' => 1,
                'category_id' => 5,
                'condition_id' => 1,
                'name' => '腕時計',
                'brand' => 'Rolax',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'price' => 15000,
                'is_sold' => true,
            ],
            [
                'id' => 2,
                'user_id' => 2,
                'category_id' => 2,
                'condition_id' => 2,
                'name' => 'HDD',
                'brand' => '西芝',
                'description' => '高速で信頼性の高いハードディスク',
                'price' => 5000,
                'is_sold' => true,
            ],
            [
                'id' => 3,
                'user_id' => 3,
                'category_id' => 10,
                'condition_id' => 3,
                'name' => '玉ねぎ3束',
                'brand' => null,
                'description' => '新鮮な玉ねぎ3束のセット',
                'price' => 300,
                'is_sold' => false,
            ],
            [
                'id' => 4,
                'user_id' => 1,
                'category_id' => 1,
                'condition_id' => 4,
                'name' => '革靴',
                'brand' => null,
                'description' => 'クラシックなデザインの革靴',
                'price' => 4000,
                'is_sold' => false,
            ],
            [
                'id' => 5,
                'user_id' => 2,
                'category_id' => 2,
                'condition_id' => 1,
                'name' => 'ノートPC',
                'brand' => null,
                'description' => '高性能なノートパソコン',
                'price' => 45000,
                'is_sold' => true,
            ],
            [
                'id' => 6,
                'user_id' => 3,
                'category_id' => 2,
                'condition_id' => 2,
                'name' => 'マイク',
                'brand' => null,
                'description' => '高音質のレコーディング用マイク',
                'price' => 8000,
                'is_sold' => true,
            ],
            [
                'id' => 7,
                'user_id' => 1,
                'category_id' => 4,
                'condition_id' => 3,
                'name' => 'ショルダーバッグ',
                'brand' => null,
                'description' => 'おしゃれなショルダーバッグ',
                'price' => 3500,
                'is_sold' => false,
            ],
            [
                'id' => 8,
                'user_id' => 2,
                'category_id' => 10,
                'condition_id' => 4,
                'name' => 'タンブラー',
                'brand' => null,
                'description' => '使いやすいタンブラー',
                'price' => 500,
                'is_sold' => true,
            ],
            [
                'id' => 9,
                'user_id' => 3,
                'category_id' => 2,
                'condition_id' => 1,
                'name' => 'コーヒーミル',
                'brand' => 'Starbacks',
                'description' => '手動のコーヒーミル',
                'price' => 4000,
                'is_sold' => true,
            ],
            [
                'id' => 10,
                'user_id' => 1,
                'category_id' => 6,
                'condition_id' => 2,
                'name' => 'メイクセット',
                'brand' => null,
                'description' => '便利なメイクアップセット',
                'price' => 2500,
                'is_sold' => true,
            ],
        ];

        foreach($items as $item) {
            DB::table('items')->insert($item);
        }
    }
}