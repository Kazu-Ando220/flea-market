<?php

return [

    'required' => ':attribute を入力してください。',
    'email' => ':attribute の形式が正しくありません。',
    'unique' => 'この :attribute は既に登録されています。',
    'confirmed' => ':attribute が一致しません。',
    'min' => [
        'string' => ':attribute は :min 文字以上で入力してください。',
    ],

    'attributes' => [
        'name' => 'お名前',
        'email' => 'メールアドレス',
        'password' => 'パスワード',
        'img_url' => '商品画像',
        'category_id' => 'カテゴリー',
        'condition_id' => '商品の状態',
        'description' => '商品の説明',
        'price' => '販売価格',
    ],
];