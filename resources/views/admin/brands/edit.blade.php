@extends('admin.layouts.admin')

@section('title', 'Sửa Thương Hiệu')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded h-100 p-4">
            <h5 class="mb-4 text-primary text-uppercase fw-bold">Cập Nhật Thương Hiệu</h5>

            <form action="{{ route('admin.brands.update', $brand->id) }}" method="POST">
                @csrf
                @method('PUT') <div class="mb-3">
                    <label class="form-label fw-bold">Tên thương hiệu <span class="text-danger">*</span></label>
                    <input type="text" name="brandname" class="form-control @error('brandname') is-invalid @enderror"
                        value="{{ old('brandname', $brand->brandname) }}" required>
                    @error('brandname')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Đường dẫn tĩnh (Slug)</label>
                    <input type="text" name="slug" class="form-control" value="{{ old('slug', $brand->slug) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Hình ảnh (URL hoặc Tên file)</label>
                    <input type="text" name="image" class="form-control" value="{{ old('image', $brand->image) }}">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Trạng thái</label>
                    <select name="status" class="form-select">
                        <option value="1" {{ old('status', $brand->status) == 1 ? 'selected' : '' }}>Hiển thị</option>
                        <option value="0" {{ old('status', $brand->status) == 0 ? 'selected' : '' }}>Ẩn</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-warning px-4"><i class="bi bi-pencil-square me-1"></i> Cập
                    nhật</button>
                <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary px-4 ms-2">Hủy</a>
            </form>
        </div>
    </div>
@endsection
