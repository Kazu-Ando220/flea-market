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
                'img_url' => 'Armani+Mens+Clock.jpg'
            ],
            [
                'id' => 2,
                'item_id' => 2,
                'img_url' => 'HDD+Hard+Disk.jpg'
            ],
            [
                'id' => 3,
                'item_id' => 3,
                'img_url' => 'iLoveIMG+d.jpg'
            ],
            [
                'id' => 4,
                'item_id' => 4,
                'img_url' => 'Leather+Shoes+Product+Photo.jpg'
            ],
            [
                'id' => 5,
                'item_id' => 5,
                'img_url' => 'Living+Room+Laptop.jpg'
            ],
            [
                'id' => 6,
                'item_id' => 6,
                'img_url' => 'Music+Mic+4632231.jpg'
            ],
            [
                'id' => 7,
                'item_id' => 7,
                'img_url' => 'Purse+fashion+pocket.jpg'
            ],
            [
                'id' => 8,
                'item_id' => 8,
                'img_url' => 'Tumbler+souvenir.jpg'
            ],
            [
                'id' => 9,
                'item_id' => 9,
                'img_url' => 'Waitress+with+Coffee+Grinder.jpg'
            ],
            [
                'id' => 10,
                'item_id' => 10,
                'img_url' => 'Makeup+Set.jpg'
            ],
        ];

        foreach($item_images as $item_image) {
            DB::table('item_images')->insert($item_image);
        }
    }
}