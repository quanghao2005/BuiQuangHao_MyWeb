<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = DB::table('posts')
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->select(
                'posts.id',
                'posts.title',
                'posts.image',
                'posts.status',
                'users.fullname'
            )
            ->orderBy('posts.id', 'desc')
            ->get();

        return view('admin.posts.index', compact('list'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('posts')->where('id', $id)->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Đã xóa bài viết!');
    }

    // Các hàm dưới đây bạn có thể triển khai thêm khi cần
    public function create()
    {
        return view('admin.posts.create');
    }
    public function store(Request $request) {}
    public function show(string $id) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
}
