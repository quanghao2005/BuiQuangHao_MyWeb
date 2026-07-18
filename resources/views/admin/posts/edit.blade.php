@extends('admin.layouts.admin')

@section('title', 'Sửa Bài Viết')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded h-100 p-4">
            <h5 class="mb-4 text-primary text-uppercase fw-bold">Cập Nhật Bài Viết</h5>

            <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label fw-bold">Tiêu đề bài viết <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title', $post->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Tác giả <span class="text-danger">*</span></label>
                        <select name="userid" class="form-select @error('userid') is-invalid @enderror" required>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ old('userid', $post->userid) == $user->id ? 'selected' : '' }}>
                                    {{ $user->fullname }}
                                </option>
                            @endforeach
                        </select>
                        @error('userid')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Loại bài viết</label>
                        <input type="text" name="type" class="form-control" value="{{ old('type', $post->type) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Hình ảnh đại diện</label>
                        <div class="d-flex flex-column gap-2">
                            <div>
                                <small class="text-muted d-block mb-1">Tải lên từ máy tính (Ưu tiên)</small>
                                <input type="file" name="image_file" class="form-control" accept="image/*">
                            </div>
                            <div>
                                <small class="text-muted d-block mb-1">Hoặc nhập đường dẫn (URL) ảnh</small>
                                <input type="text" name="image_link" class="form-control" placeholder="https://..." value="{{ old('image_link', (Str::startsWith($post->image, 'http') ? $post->image : '')) }}">
                            </div>
                        </div>
                        @if($post->image)
                            <div class="mt-2 p-2 border rounded bg-white">
                                <small class="d-block mb-1 text-muted">Ảnh hiện tại:</small>
                                @if(Str::startsWith($post->image, 'http'))
                                    <img src="{{ $post->image }}" alt="Current Image" width="120" class="img-thumbnail">
                                @else
                                    <img src="{{ asset('storage/posts/' . $post->image) }}" alt="Current Image" width="120" class="img-thumbnail" onerror="this.src='https://via.placeholder.com/120'">
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold">Chi tiết bài viết</label>
                        <textarea name="detail" id="summernote" class="form-control" rows="5">{{ old('detail', $post->content) }}</textarea>
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label fw-bold">Trạng thái</label>
                        <select name="status" class="form-select">
                            <option value="1" {{ old('status', $post->status) == 1 ? 'selected' : '' }}>Đăng bài (Hiển
                                thị)</option>
                            <option value="0" {{ old('status', $post->status) == 0 ? 'selected' : '' }}>Bản nháp (Ẩn)
                            </option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-warning px-4"><i class="bi bi-pencil-square me-1"></i> Cập
                    nhật</button>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary px-4 ms-2">Hủy</a>
            </form>
        </div>
    </div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Nhập nội dung bài viết...',
            tabsize: 2,
            height: 400,
            dialogsInBody: true,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>
@endpush
