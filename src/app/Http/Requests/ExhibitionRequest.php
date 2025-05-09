<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'name' => 'required', // 商品名
            'description' => 'required|max:255', // 商品名
            'image' => 'required|image|mimes:jpeg,png', // 商品画像
            'category_id' => 'required|array', // 商品カテゴリー
            'category_id.*' => 'required|integer|exists:categories,id',
            'condition_id' => 'required', // 商品の状態
            'price' => 'required|integer|min:0', // 商品価格
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名は入力必須です',
            'description.required' => '商品説明は入力必須です',
            'description.max' => '商品説明は255文字以内で入力してください',
            'image.required' => '商品画像はアップロード必須です',
            'image.image' => 'アップロードされたファイルは画像である必要があります',
            'image.mimes' => '画像はjpegまたはpng形式でアップロードしてください',
            'category_id.required' => '商品のカテゴリーは選択必須です',
            'category_id.array' => 'カテゴリーの形式が不正です',
            'category_id.*.required' => 'カテゴリーを正しく選択してください',
            'category_id.*.exists' => '選択されたカテゴリーが存在しません',
            'condition_id.required' => '商品の状態は選択必須です',
            'price.required' => '商品価格は入力必須です。',
            'price.integer' => '商品価格は数値で入力してください',
            'price.min' => '商品価格は0円以上で入力してください',
        ];
    }
}
