<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'name' => 'max:20',
            'comment' => 'required | min:10 | max:200',
        ];
    }

    public function messages(): array
    {
        return [
            'name.max' => ':max 文字以内まで',
            'comment.required' => 'コメントを記入してください',
            'comment.min' => '最低 :min 文字以上',
            'comment.max' => ':max 文字まで',
        ];
    }
}
