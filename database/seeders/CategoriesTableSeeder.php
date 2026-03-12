<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['id' => 1, 'parent_id' => null, 'content' => 'ファッション'],
            ['id' => 2, 'parent_id' => null, 'content' => '家電'],
            ['id' => 3, 'parent_id' => null, 'content' => 'インテリア'],
            ['id' => 4, 'parent_id' => null, 'content' => 'レディース'],
            ['id' => 5, 'parent_id' => null, 'content' => 'メンズ'],
            ['id' => 6, 'parent_id' => null, 'content' => 'コスメ'],
            ['id' => 7, 'parent_id' => null, 'content' => '本'],
            ['id' => 8, 'parent_id' => null, 'content' => 'ゲーム'],
            ['id' => 9, 'parent_id' => null, 'content' => 'スポーツ'],
            ['id' => 10, 'parent_id' => null, 'content' => 'キッチン'],
            ['id' => 11, 'parent_id' => null, 'content' => 'ハンドメイド'],
            ['id' => 12, 'parent_id' => null, 'content' => 'アクセサリー'],
            ['id' => 13, 'parent_id' => null, 'content' => 'おもちゃ'],
            ['id' => 14, 'parent_id' => null, 'content' => 'ベビー・キッズ'],
        ];

        foreach($categories as $category) {
            DB::table('categories')->insert($category);
        }
    }
}