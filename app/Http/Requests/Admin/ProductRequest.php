<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('product') ?? $this->route('id');

        return [
            'productname' => [
                'required',
                'string',
                'min:5',
                'max:255',
                Rule::unique('products', 'productname')->ignore($id),
            ],
            'slug' => [
                'required',
                'string',
                'min:5',
                'max:255',
                Rule::unique('products', 'slug')->ignore($id),
                'regex:/^[a-zA-Z0-9\-\_]+$/',
            ],
            'price' => 'required|numeric|min:0|max:10000000',
            'pricediscount' => 'nullable|numeric|min:0|lte:price',
            'status' => 'required|in:0,1',
            'cateid' => 'required|exists:categories,cateid',
            'brandid' => 'required|exists:brands,brandid',
            'description' => [
                'nullable',
                'string',
                'not_regex:/[@!$^]/'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute không được để trống.',
            'min' => ':attribute phải từ :min trở lên.',
            'max' => ':attribute không vượt quá :max.',
            'unique' => ':attribute đã tồn tại.',
            'slug.regex' => ':attribute chỉ được chứa chữ, số, dấu gạch dưới (_) và dấu gạch ngang (-).',
            'numeric' => ':attribute phải là kiểu số.',
            'string' => ':attribute phải là kiểu chuỗi.',
            'lte' => ':attribute không được lớn hơn Giá.',
            'in' => ':attribute không hợp lệ.',
            'exists' => ':attribute không tồn tại trong hệ thống.',
            'not_regex' => ':attribute không được chứa các ký tự đặc biệt (@, !, $, ^).'
        ];
    }

    public function attributes(): array
    {
        return [
            'productname' => 'Tên sản phẩm',
            'slug' => 'Đường dẫn (Slug)',
            'price' => 'Giá bán',
            'pricediscount' => 'Giá khuyến mãi',
            'cateid' => 'Danh mục',
            'brandid' => 'Thương hiệu',
            'status' => 'Trạng thái',
            'description' => 'Mô tả',
        ];
    }
}
