<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'avatar'    => ['nullable', 'image', 'mimes:jpeg,png'],
            'name'      => ['required', 'string', 'max:20'],
            'post_code' => ['required', 'regex:/^\d{3}-\d{4}$/'],
            'address'   => ['required', 'string'],
            'building'  => ['nullable', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'avatar.mimes'     => '画像はjpegまたはpng形式でアップロードしてください。',
            'name.required'    => 'ユーザー名を入力してください。',
            'name.max'         => 'ユーザー名は20文字以内で入力してください。',
            'post_code.required' => '郵便番号を入力してください。',
            'post_code.regex'  => '郵便番号はハイフンありの8文字で入力してください。',
            'address.required' => '住所を入力してください。',
        ];
    }
}