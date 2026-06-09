@extends('admin.layouts.admin')

@section('title', 'Sửa Bài Viết')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded h-100 p-4">
            <h5 class="mb-4 text-primary text-uppercase fw-bold">Cập Nhật Bài Viết</h5>

            <form action="{{ route('admin.posts.update', $post->id) }}" method="POST">
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
                        <input type="text" name="image" class="form-control" value="{{ old('image', $post->image) }}">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold">Chi tiết bài viết</label>
                        <textarea name="detail" class="form-control" rows="5">{{ old('detail', $post->detail) }}</textarea>
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
