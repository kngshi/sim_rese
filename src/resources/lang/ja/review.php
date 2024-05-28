<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'required' => ':attribute は必須です。',
    'exists' => ':attribute が存在しません。',
    'integer' => ':attribute は整数でなければなりません。',
    'min' => [
        'numeric' => ':attribute は :min 以上でなければなりません。',
    ],
    'max' => [
        'numeric' => ':attribute は :max 以下でなければなりません。',
    ],
    'string' => ':attribute は文字列でなければなりません。',

    // その他のバリデーションメッセージ
    'attributes' => [
        'shop_id' => '店舗ID',
        'rating' => '評価',
        'comment' => 'コメント',
    ],
];