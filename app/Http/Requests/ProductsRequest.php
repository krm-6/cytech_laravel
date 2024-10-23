<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductsRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return  [
                'product_name' => 'required | string',
                'price' => 'required | integer',
                'stock' => 'required | numeric',
                'comment' => 'nullable | max:10000',
                'company_id' => 'required',
                 ];
    }

    public function messages()
    {
        return [
            'product_name.required' => '名前は必須です。',
            'product_name.string' => '名前は文字を入力してください。',
            'price.required' => '価格は必須です。',
            'price.integer' => '価格は整数で入力してください。',
            'stock.numeric' => '在庫数は数値で入力してください。',
            'stock.required' => '在庫数は必須です。',
            'comment' => 'コメントは10000文字以内で入力してください。',
            'company_id.required' => 'メーカー名を入力してください。' ,
        ];
    }
}
