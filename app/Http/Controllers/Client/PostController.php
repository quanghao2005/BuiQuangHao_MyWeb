<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        // Lấy danh sách bài viết đang hiển thị (status = 1), sắp xếp mới nhất
        $posts = Post::where('status', 1)->orderBy('created_at', 'desc')->paginate(12);
        return view('client.posts.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->where('status', 1)->firstOrFail();
        
        // Lấy bài viết liên quan (cùng trạng thái, khác ID hiện tại)
        $relatedPosts = Post::where('status', 1)
            ->where('id', '!=', $post->id)
            ->inRandomOrder()
            ->take(5)
            ->get();

        return view('client.posts.show', compact('post', 'relatedPosts'));
    }
}
