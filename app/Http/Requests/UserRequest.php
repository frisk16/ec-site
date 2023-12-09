<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
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
            'email' => 'unique:users,email,'.Auth::user()->email.',email',
            'last_name' => 'required | max:30',
            'first_name' => 'required | max:30',
            'age' => 'required',
            'postal_code' =>'required | max:7',
            'area' => 'required',
            'address' => 'required | max:255',
            'phone_number' => 'required | max:12',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => '入力必須です',
            'email.unique' => '既に使用されています',
            'last_name.required' => '入力必須です',
            'last_name.max' => ':max文字以内',
            'first_name.required' => '入力必須です',
            'first_name.max' => ':max文字以内',
            'age.required' => '選択必須です',
            'postal_code.required' => '入力必須です',
            'postal_code.max' => ':max文字以内',
            'area.required' => '選択必須です',
            'address.required' => '入力必須です',
            'address.max' => ':max文字以内',
            'phone_number.required' => '入力必須です',
            'phone_number.max' => ':max文字以内',
        ];
    }
}
