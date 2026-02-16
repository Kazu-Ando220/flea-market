<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemImagesTableSeeder extends Seeder
{
    public function run(): void
    {
        $item_images = [
            [
                'id' => 1,
                'item_id' => 1,
                'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg'
            ],
            [
                'id' => 2,
                'item_id' => 2,
                'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg'
            ],
            [
                'id' => 3,
                'item_id' => 3,
                'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg'
            ],
            [
                'id' => 4,
                'item_id' => 4,
                'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg'
            ],
            [
                'id' => 5,
                'item_id' => 5,
                'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg'
            ],
            [
                'id' => 6,
                'item_id' => 6,
                'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg'
            ],
            [
                'id' => 7,
                'item_id' => 7,
                'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg'
            ],
            [
                'id' => 8,
                'item_id' => 8,
                'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg'
            ],
            [
                'id' => 9,
                'item_id' => 9,
                'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg'
            ],
            [
                'id' => 10,
                'item_id' => 10,
                'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg'
            ],
        ];

        foreach($item_images as $item_image) {
            DB::table('item_images')->insert($item_image);
        }
    }
}