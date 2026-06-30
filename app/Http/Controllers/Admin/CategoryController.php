<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str; // Import thư viện tạo slug
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($limit = 10)
    {
        $list = Category::select('cateid', 'catename', 'slug', 'image', 'status')
            ->orderBy('catename', 'asc')
            ->paginate($limit);

        return view('admin.categories.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'catename' => 'required|min:3|max:100|unique:categories,catename',
                'slug' => [
                    'required',
                    'min:5',
                    'max:150',
                    'unique:categories,slug',
                    'regex:/^[a-z0-9\-]+$/'
                ],
                'img' => [
                    'nullable',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:200'
                ],
                'status' => 'required|in:0,1'
            ],
            [
                'required' => ':attribute không được để trống.',
                'min' => ':attribute phải từ :min ký tự trở lên.',
                'max' => ':attribute không vượt quá :max ký tự.',
                'unique' => ':attribute đã tồn tại.',
                'slug.regex' => ':attribute chỉ được chứa chữ thường, số và dấu gạch ngang (-).',
                'status.in' => ':attribute không hợp lệ.',
                'img.image' => ':attribute phải là hình ảnh.',
                'img.mimes' => ':attribute chỉ chấp nhận định dạng: jpg, jpeg, png, webp.',
                'img.max' => ':attribute không vượt quá 200 KB.',
            ],
            [
                'catename' => 'Tên loại',
                'slug' => 'Đường dẫn (Slug)',
                'img' => 'Hình ảnh',
                'status' => 'Trạng thái'
            ]
        );

        try {
            $fileName = null;
            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $fileName = Str::slug($request->catename) . '-' . time() . '.' . $file->extension();
                $file->storeAs('categories', $fileName, 'public');
            }

            Category::create([
                'catename' => $request->catename,
                'slug'     => $request->slug,
                'image'    => $fileName,
                'status'   => $request->status
            ]);

            return redirect()->route('admin.categories.index')->with('success', 'Thêm thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::where('cateid', $id)->firstOrFail();

        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::where('cateid', $id)->firstOrFail();

        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate dữ liệu
        $request->validate(
            // Param 1: Rules - khai báo các quy tắc kiểm tra dữ liệu
            [
                'catename' => 'required|min:3|max:100|unique:categories,catename,' . $id . ',cateid',
                'slug' => [
                    'required',
                    'min:5',
                    'max:150',
                    'regex:/^[a-z0-9-]+$/',
                    Rule::unique('categories', 'slug')->ignore($id, 'cateid'),
                ],
                'img' => [
                    'nullable',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:200'
                ],
                'status' => 'required|in:0,1'
            ],
            // Param 2: Messages - tùy chỉnh nội dung thông báo lỗi
            [
                'required' => ':attribute không được để trống.',
                'min' => ':attribute phải từ :min ký tự trở lên.',
                'max' => ':attribute không vượt quá :max ký tự.',
                'unique' => ':attribute đã tồn tại.',
                'slug.regex' => ':attribute chỉ được chứa chữ thường, số và dấu gạch ngang (-).',
                'status.in' => ':attribute không hợp lệ.',
                'img.image' => ':attribute phải là hình ảnh.',
                'img.mimes' => ':attribute chỉ chấp nhận định dạng: jpg, jpeg, png, webp.',
                'img.max' => ':attribute không vượt quá 200 KB.',
            ],
            // Param 3: Attributes - tên hiển thị của các trường
            [
                'catename' => 'Tên loại',
                'slug' => 'Đường dẫn (Slug)',
                'img' => 'Hình ảnh',
                'status' => 'Trạng thái'
            ]
        );

        try {
            // Tìm danh mục cần sửa và cập nhật dữ liệu mới
            $category = Category::where('cateid', $id)->firstOrFail();

            $fileName = $category->image;
            if ($request->hasFile('img')) {
                if ($fileName) {
                    Storage::disk('public')->delete('categories/' . $fileName);
                }
                $file = $request->file('img');
                $fileName = Str::slug($request->catename) . '-' . time() . '.' . $file->extension();
                $file->storeAs('categories', $fileName, 'public');
            }

            $category->update([
                'catename' => $request->catename,
                'slug'     => $request->slug,
                'image'    => $fileName,
                'status'   => $request->status ?? $category->status,
            ]);

            return redirect()->route('admin.categories.index')->with('success', 'Cập nhật thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Category::where('cateid', $id)->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Xóa thành công!');
    }
}
