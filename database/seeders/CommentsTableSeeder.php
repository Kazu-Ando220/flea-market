<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentsTableSeeder extends Seeder
{
    public function run(): void
    {
        $comments = [
            [
                'id' => 1,
                'user_id' => 1,
                'item_id' => 5,
                'content' => 'とても滑らかな操作性が気に入った！'
            ],
            [
                'id' => 2,
                'user_id' => 3,
                'item_id' => 8,
                'content' => '見た目はイマイチだったが、手になじむ感触が非常にいいね！'
            ],
        ];

        foreach($comments as $comment) {
            DB::table('comments')->insert($comment);
        }
    }
}