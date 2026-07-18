@extends('client.layouts.app')

@section('title', $post->title)

@section('content')
<div class="row">
    <div class="col-lg-8">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('client.posts.index') }}" class="text-decoration-none">Bài viết</a></li>
                <li class="breadcrumb-item active text-truncate" aria-current="page" style="max-width: 200px;">{{ $post->title }}</li>
            </ol>
        </nav>

        <article class="bg-white p-4 p-md-5 rounded-4 shadow-sm mb-5">
            <h1 class="fw-bolder mb-3" style="line-height: 1.4;">{{ $post->title }}</h1>
            
            <div class="d-flex align-items-center text-muted mb-4 pb-3 border-bottom">
                <div class="me-4"><i class="bi bi-calendar-event me-1"></i> {{ $post->created_at->format('d/m/Y H:i') }}</div>
                @if($post->user)
                    <div><i class="bi bi-person-circle me-1"></i> Tác giả: <strong>{{ $post->user->fullname }}</strong></div>
                @endif
            </div>

            @if(str_starts_with($post->image, 'http'))
                <div class="mb-4 text-center">
                    <img src="{{ $post->image }}" class="img-fluid rounded-3 shadow-sm" alt="{{ $post->title }}">
                </div>
            @elseif($post->image && file_exists(public_path('storage/posts/' . $post->image)))
                <div class="mb-4 text-center">
                    <img src="{{ asset('storage/posts/' . $post->image) }}" class="img-fluid rounded-3 shadow-sm" alt="{{ $post->title }}">
                </div>
            @endif

            <div class="post-content lh-lg" style="font-size: 1.05rem;">
                {!! $post->content !!}
            </div>
            
            <div class="mt-5 pt-4 border-top text-center">
                <h5 class="fw-bold mb-3">Chia sẻ bài viết này</h5>
                <div class="d-flex justify-content-center gap-2">
                    <button class="btn btn-primary rounded-circle" style="width: 40px; height: 40px;"><i class="bi bi-facebook"></i></button>
                    <button class="btn btn-info text-white rounded-circle" style="width: 40px; height: 40px;"><i class="bi bi-twitter"></i></button>
                    <button class="btn btn-danger rounded-circle" style="width: 40px; height: 40px;"><i class="bi bi-pinterest"></i></button>
                    <button class="btn btn-secondary rounded-circle" style="width: 40px; height: 40px;" onclick="navigator.clipboard.writeText(window.location.href); alert('Đã copy link!');"><i class="bi bi-link-45deg"></i></button>
                </div>
            </div>
        </article>
    </div>

    <!-- Sidebar: Bài viết liên quan -->
    <div class="col-lg-4">
        <div class="bg-white p-4 rounded-4 shadow-sm sticky-top" style="top: 100px; z-index: 1;">
            <h4 class="fw-bold mb-4 section-title text-primary">Bài viết khác</h4>
            
            <div class="d-flex flex-column gap-3">
                @foreach($relatedPosts as $related)
                    <a href="{{ route('client.posts.show', $related->slug) }}" class="text-decoration-none text-dark row g-0 align-items-center hover-bg-light p-2 rounded transition">
                        <div class="col-4">
                            @if(str_starts_with($related->image, 'http'))
                                <img src="{{ $related->image }}" class="img-fluid rounded shadow-sm" alt="{{ $related->title }}" style="height: 70px; object-fit: cover; width: 100%;">
                            @elseif($related->image && file_exists(public_path('storage/posts/' . $related->image)))
                                <img src="{{ asset('storage/posts/' . $related->image) }}" class="img-fluid rounded shadow-sm" alt="{{ $related->title }}" style="height: 70px; object-fit: cover; width: 100%;">
                            @else
                                <img src="https://via.placeholder.com/150?text=News" class="img-fluid rounded shadow-sm" alt="No image" style="height: 70px; object-fit: cover; width: 100%;">
                            @endif
                        </div>
                        <div class="col-8 ps-3">
                            <h6 class="mb-1 fw-bold line-clamp-2" style="font-size: 0.95rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ $related->title }}
                            </h6>
                            <small class="text-muted"><i class="bi bi-clock me-1"></i>{{ $related->created_at->format('d/m/Y') }}</small>
                        </div>
                    </a>
                @endforeach
                
                @if($relatedPosts->count() == 0)
                    <p class="text-muted text-center mb-0">Không có bài viết nào khác.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .hover-bg-light:hover {
        background-color: #f8f9fa;
    }
    .transition {
        transition: all 0.3s ease;
    }
    .post-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 15px 0;
    }
</style>
@endsection
