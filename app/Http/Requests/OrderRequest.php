<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'des_name' => 'required | max:20',
            'des_postal_code' => 'required | max:7',
            'des_address' => 'required | max:200',
            'des_phone_number' => 'required | max:12'
        ];
    }

    public function messages(): array
    {
        return [
            'des_name.required' => '名前必須',
            'des_name.max' => ':max 文字以内',
            'des_postal_code.required' => '郵便番号必須',
            'des_postal_code.max' => ':max 桁以内',
            'des_address.required' => '住所必須',
            'des_address.max' => '文字数オーバー',
            'des_phone_number.required' => '連絡先必須',
            'des_phone_number.max' => ':max 桁以内',
        ];
    }
}
