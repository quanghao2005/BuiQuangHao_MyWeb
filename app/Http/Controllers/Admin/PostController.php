<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\PostRequest;
use App\Models\User;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($limit = 10)
    {
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
    public function store(PostRequest $request)
    {
        try {
            $imageName = 'default.jpg';
            
            if ($request->hasFile('image_file')) {
                $file = $request->file('image_file');
                $imageName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/posts', $imageName);
            } elseif ($request->filled('image_link')) {
                $imageName = $request->image_link;
            }

            Post::create([
                'title'   => $request->title,
                'slug'    => $request->slug ?? Str::slug($request->title), // Tự động tạo slug nếu trống
                'content' => $request->detail ?? 'Nội dung mặc định', // Cột đúng trong DB là content
                'status'  => $request->status ?? 1,
                'user_id' => $request->userid, // Cột đúng trong DB là user_id
                'image'   => $imageName,
            ]);

            return redirect()->route('admin.posts.index')->with('success', 'Thêm bài viết thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Lỗi khi thêm bài viết: ' . $e->getMessage());
        }
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
    public function update(PostRequest $request, string $id)
    {
        try {
            $post = Post::findOrFail($id);

            $imageName = $post->image;
            if ($request->hasFile('image_file')) {
                $file = $request->file('image_file');
                $imageName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/posts', $imageName);
            } elseif ($request->filled('image_link')) {
                $imageName = $request->image_link;
            }

            $post->update([
                'title'   => $request->title,
                'slug'    => $request->slug ?? Str::slug($request->title),
                'content' => $request->detail ?? $post->content,
                'status'  => $request->status ?? $post->status,
                'user_id' => $request->userid,
                'image'   => $imageName,
            ]);

            return redirect()->route('admin.posts.index')->with('success', 'Cập nhật bài viết thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Lỗi khi cập nhật bài viết: ' . $e->getMessage());
        }
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
