@extends('admin.layouts.admin')

@section('content')
    <div class="container-fluid mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 font-weight-bold text-primary">Chỉnh sửa Danh mục</h5>
            </div>

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.categories.update', $category->cateid) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <div class="mb-3">
                        <label for="catename" class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('catename') is-invalid @enderror" id="catename"
                            name="catename" value="{{ old('catename', $category->catename) }}"
                            placeholder="Nhập tên danh mục..." required>

                        @error('catename')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Đường dẫn (Slug) <span class="text-danger">*</span></label>
                        <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" 
                               value="{{ old('slug', $category->slug) }}" required>
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 img-group">
                        <label class="form-label">Hình ảnh</label>
                        <input type="file" name="img" class="form-control img-input">
                        <div class="img-preview mt-2">
                            @if ($category->image)
                                <img src="{{ asset('storage/categories/' . $category->image) }}" width="150" class="img-thumbnail" style="margin: 5px;">
                            @endif
                        </div>
                        @error('img')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label d-block fw-bold">Trạng thái</label>
                        <input type="radio" class="btn-check" name="status" id="active" value="1" {{ old('status', $category->status) == 1 ? 'checked' : '' }}>
                        <label class="btn btn-outline-success" for="active">Hiển thị</label>

                        <input type="radio" class="btn-check" name="status" id="inactive" value="0" {{ old('status', $category->status) == 0 ? 'checked' : '' }}>
                        <label class="btn btn-outline-danger" for="inactive">Ẩn</label>
                        
                        @error('status')
                            <span class="text-danger d-block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary px-4">Lưu thay đổi</button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary px-4 ms-2">Hủy bỏ</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
