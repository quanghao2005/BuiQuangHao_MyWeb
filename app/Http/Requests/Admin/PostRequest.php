<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('post') ?? $this->route('id');

        return [
            'title'  => 'required|string|max:255',
            'userid' => 'required|exists:users,id',
            // optional fields
            'slug'   => 'nullable|string|max:255',
            'detail' => 'nullable|string',
            'status' => 'required|in:0,1',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'image_link' => 'nullable|string'
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'  => 'Vui lòng nhập tiêu đề bài viết.',
            'userid.required' => 'Vui lòng chọn người đăng.',
            'userid.exists'   => 'Người đăng không hợp lệ.'
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'Tiêu đề',
            'userid' => 'Người đăng'
        ];
    }
}
