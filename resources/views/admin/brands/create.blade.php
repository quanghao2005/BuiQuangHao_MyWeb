@extends('admin.layouts.admin')
@section('title', 'Thêm Thương Hiệu')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded p-4">
            <h5 class="mb-4 text-primary text-uppercase fw-bold">Thêm Thương Hiệu Mới</h5>
            
            {{-- Gọi component alert --}}
            <x-admin.alert />

            <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">Tên thương hiệu <span class="text-danger">*</span></label>
                    <input type="text" name="brandname" class="form-control" placeholder="Nhập tên thương hiệu..."
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Đường dẫn (Slug) <span class="text-danger">*</span></label>
                    <input type="text" name="slug" class="form-control" placeholder="Nhập đường dẫn tĩnh..." required>
                </div>

                <div class="mb-3 img-group">
                    <label class="form-label fw-bold">Hình ảnh</label>
                    <input type="file" name="img" class="form-control img-input">
                    <div class="img-preview mt-2"></div>
                    @error('img')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Trạng thái <span class="text-danger">*</span></label>
                    <select name="status" class="form-select">
                        <option value="">-- Chọn trạng thái --</option>
                        <option value="1" {{ old('status') === '1' ? 'selected' : '' }}>Hiển thị</option>
                        <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>Ẩn</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success px-4 mt-3">Lưu dữ liệu</button>
                <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary px-4 mt-3 ms-2">Hủy</a>
            </form>
        </div>
    </div>
@endsection
