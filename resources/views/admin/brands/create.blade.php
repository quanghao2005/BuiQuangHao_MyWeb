@extends('admin.layouts.admin')
@section('title', 'Thêm Thương Hiệu')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded p-4">
            <h5 class="mb-4 text-primary text-uppercase fw-bold">Thêm Thương Hiệu Mới</h5>
            <form action="{{ route('admin.brands.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">Tên thương hiệu <span class="text-danger">*</span></label>
                    <input type="text" name="brandname" class="form-control" placeholder="Nhập tên thương hiệu..."
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Trạng thái</label>
                    <select name="status" class="form-select">
                        <option value="1">Hiển thị</option>
                        <option value="0">Ẩn</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success px-4 mt-3">Lưu dữ liệu</button>
                <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary px-4 mt-3 ms-2">Hủy</a>
            </form>
        </div>
    </div>
@endsection
