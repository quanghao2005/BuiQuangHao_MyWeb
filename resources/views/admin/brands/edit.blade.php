@extends('admin.layouts.admin')

@section('title', 'Sửa Thương Hiệu')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded h-100 p-4">
            <h5 class="mb-4 text-primary text-uppercase fw-bold">Cập Nhật Thương Hiệu</h5>

            <form action="{{ route('admin.brands.update', $brand->brandid) }}" method="POST" enctype="multipart/form-data">
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

                <div class="mb-3 img-group">
                    <label class="form-label fw-bold">Hình ảnh</label>
                    <input type="file" name="img" class="form-control img-input">
                    <div class="img-preview mt-2">
                        @if ($brand->image)
                            <img src="{{ asset('storage/brands/' . $brand->image) }}" width="150" class="img-thumbnail" style="margin: 5px;">
                        @endif
                    </div>
                    @error('img')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Trạng thái <span class="text-danger">*</span></label>
                    <div class="d-flex align-items-center">
                        <input type="radio" class="btn-check" name="status" id="active" value="1" {{ old('status', $brand->status) == 1 ? 'checked' : '' }}>
                        <label class="btn btn-success" for="active">Hiển thị</label>

                        <input type="radio" class="btn-check" name="status" id="inactive" value="0" {{ old('status', $brand->status) == 0 ? 'checked' : '' }}>
                        <label class="btn btn-outline-danger ms-1" for="inactive">Ẩn</label>

                        @error('status')
                            <span class="text-danger ms-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-warning px-4"><i class="bi bi-pencil-square me-1"></i> Cập
                    nhật</button>
                <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary px-4 ms-2">Hủy</a>
            </form>
        </div>
    </div>
@endsection
