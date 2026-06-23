<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('category') ?? $this->route('cateid');

        return [
            'catename' => [
                'required',
                'min:3',
                'max:100',
                Rule::unique('categories', 'catename')->ignore($id, 'cateid'),
            ],
            'slug' => [
                'required',
                'min:5',
                'max:150',
                'regex:/^[a-z0-9\-]+$/',
                Rule::unique('categories', 'slug')->ignore($id, 'cateid'),
            ],
            'status' => 'required|in:0,1'
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute không được để trống.',
            'min' => ':attribute phải từ :min ký tự trở lên.',
            'max' => ':attribute không vượt quá :max ký tự.',
            'unique' => ':attribute đã tồn tại.',
            'slug.regex' => ':attribute chỉ được chứa chữ thường, số và dấu gạch ngang (-).',
            'status.in' => ':attribute không hợp lệ.'
        ];
    }

    public function attributes(): array
    {
        return [
            'catename' => 'Tên loại',
            'slug' => 'Đường dẫn (Slug)',
            'status' => 'Trạng thái'
        ];
    }
}
