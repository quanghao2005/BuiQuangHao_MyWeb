@extends('client.layouts.app')

@section('title', 'Bài viết công nghệ')

@section('content')
<div class="row">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Bài viết công nghệ</li>
            </ol>
        </nav>
        
        <h2 class="fw-bold mb-4 border-start border-4 border-primary ps-2"><i class="bi bi-newspaper text-primary me-2"></i>Tin Tức Công Nghệ</h2>
    </div>
</div>

<div class="row g-4">
    @forelse($posts as $post)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm product-card">
                <a href="{{ route('client.posts.show', $post->slug) }}" class="text-decoration-none text-dark">
                    @if(str_starts_with($post->image, 'http'))
                        <img src="{{ $post->image }}" class="card-img-top" alt="{{ $post->title }}" style="height: 200px; object-fit: cover;">
                    @elseif($post->image && file_exists(public_path('storage/posts/' . $post->image)))
                        <img src="{{ asset('storage/posts/' . $post->image) }}" class="card-img-top" alt="{{ $post->title }}" style="height: 200px; object-fit: cover;">
                    @else
                        <img src="https://via.placeholder.com/800x400?text=News" class="card-img-top" alt="No image" style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <small class="text-muted mb-2 d-block"><i class="bi bi-calendar3 me-1"></i> {{ $post->created_at->format('d/m/Y') }}</small>
                        <h5 class="card-title fw-bold line-clamp-2" style="font-size: 1.1rem; min-height: 2.5rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $post->title }}
                        </h5>
                        <p class="card-text text-muted line-clamp-3" style="font-size: 0.9rem; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ strip_tags(html_entity_decode($post->content)) }}
                        </p>
                    </div>
                </a>
                <div class="card-footer bg-white border-top-0 pt-0">
                    <a href="{{ route('client.posts.show', $post->slug) }}" class="text-primary fw-bold text-decoration-none hover-primary">
                        Đọc tiếp <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <i class="bi bi-journal-x fs-1 text-muted mb-3"></i>
            <h4 class="text-muted">Chưa có bài viết nào</h4>
            <p>Vui lòng quay lại sau!</p>
        </div>
    @endforelse
</div>

<div class="d-flex justify-content-center mt-5">
    {{ $posts->links('pagination::bootstrap-5') }}
</div>
@endsection
