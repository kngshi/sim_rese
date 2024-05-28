<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'shop_id' => 'required|exists:shops,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'shop_id.required' => '店舗IDは必須です。',
            'shop_id.exists' => '選択された店舗IDは存在しません。',
            'rating.required' => '評価は必須です。',
            'rating.integer' => '評価は数値でなければなりません。',
            'rating.min' => '評価は1以上でなければなりません。',
            'rating.max' => '評価は5以下でなければなりません。',
            'comment.string' => 'コメントは文字列でなければなりません。',
        ];
    }
}
