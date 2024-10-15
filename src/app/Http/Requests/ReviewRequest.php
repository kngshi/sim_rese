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
        return true;
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
            'comment' => 'required|string|max:400',
            'img_url' => 'nullable|image|mimes:jpeg,png|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'shop_id.required' => '店舗IDは必須です。',
            'shop_id.exists' => '選択された店舗IDは存在しません。',
            'rating.required' => '評価を選択してください。',
            'rating.integer' => '評価は数値でなければなりません。',
            'rating.min' => '評価は星1つ以上でなければなりません。',
            'rating.max' => '評価は星5つ以下でなければなりません。',
            'comment.required' => '口コミは入力必須です。',
            'comment.string' => '口コミは文字列でなければなりません。',
            'comment.max' => '口コミは400字以内で入力してください。',
            'img_url.required' => '画像はアップロード必須です。',
            'img_url.image' => 'アップロードするファイルは画像でなければなりません。',
            'img_url.mimes' => '画像はjpegまたはpng形式でなければなりません。',
            'img_url.max' => '画像ファイルのサイズは2MB以下でなければなりません。',
        ];
    }
}
