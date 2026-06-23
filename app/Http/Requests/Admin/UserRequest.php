<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('user') ?? $this->route('id');

        $rules = [
            'fullname' => 'required|string|max:255',
            'email'    => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($id),
            ],
        ];

        // Mật khẩu chỉ bắt buộc khi tạo mới
        if ($this->isMethod('post')) {
            $rules['password'] = 'required|string|min:6';
        } else {
            $rules['password'] = 'nullable|string|min:6';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'fullname.required' => 'Vui lòng nhập họ tên.',
            'email.required'    => 'Vui lòng nhập email.',
            'email.unique'      => 'Email này đã tồn tại trong hệ thống.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min'      => 'Mật khẩu phải chứa ít nhất :min ký tự.'
        ];
    }

    public function attributes(): array
    {
        return [
            'fullname' => 'Họ và tên',
            'email' => 'Địa chỉ email',
            'password' => 'Mật khẩu'
        ];
    }
}
