<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User; // Cần import User để lấy danh sách tác giả
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($limit = 10)
    {
        // SỬA: Bỏ cột 'type' (không tồn tại trong DB) 
        // SỬA: Đảm bảo các cột như 'user_id' đúng với tên cột trong DB (xem lại phpMyAdmin của bạn)
        $list = Post::with(['user:id,fullname'])
            ->select('id', 'title', 'image', 'status', 'user_id', 'created_at')
            ->orderBy('id', 'desc')
            ->paginate($limit);

        return view('admin.posts.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Lấy danh sách user để chọn làm tác giả bài viết
        $users = User::select('id', 'fullname')->get();
        return view('admin.posts.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'  => 'required|string|max:255',
            'userid' => 'required|exists:users,id', // Đảm bảo userid phải tồn tại trong bảng users
        ]);

        Post::create([
            'title'  => $request->title,
            'slug'   => $request->slug ?? Str::slug($request->title), // Tự động tạo slug nếu trống
            'detail' => $request->detail ?? '',
            'type'   => $request->type ?? 'normal',
            'status' => $request->status ?? 1,
            'userid' => $request->userid,
            'image'  => $request->image ?? null,
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Thêm bài viết thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::with(['user'])->findOrFail($id);
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        $users = User::select('id', 'fullname')->get();

        return view('admin.posts.edit', compact('post', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title'  => 'required|string|max:255',
            'userid' => 'required|exists:users,id',
        ]);

        $post = Post::findOrFail($id);

        $post->update([
            'title'  => $request->title,
            'slug'   => $request->slug ?? Str::slug($request->title),
            'detail' => $request->detail ?? $post->detail,
            'type'   => $request->type ?? $post->type,
            'status' => $request->status,
            'userid' => $request->userid,
            // Giữ lại ảnh cũ nếu không có ảnh mới cập nhật
            'image'  => $request->image ?? $post->image,
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Cập nhật bài viết thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Đã sửa lại thành Eloquent thay cho DB::table
        Post::findOrFail($id)->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Đã xóa bài viết thành công!');
    }
}
