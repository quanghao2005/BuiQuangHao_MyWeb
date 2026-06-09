@extends('admin.layouts.admin')
@section('title', 'Thêm Sản Phẩm')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded p-4">
            <h5 class="mb-4 text-primary text-uppercase fw-bold">Thêm Sản Phẩm Mới</h5>
            <form action="{{ route('admin.products.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Tên sản phẩm (VD: iPhone 15 Pro Max) <span
                                class="text-danger">*</span></label>
                        <input type="text" name="productname" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Giá bán (VNĐ) <span class="text-danger">*</span></label>
                        <input type="number" name="price" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Danh mục <span class="text-danger">*</span></label>
                        <select name="cateid" class="form-select" required>
                            <option value="">-- Chọn Danh Mục --</option>
                            @foreach ($categories as $cate)
                                <option value="{{ $cate->cateid }}">{{ $cate->catename }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Thương hiệu <span class="text-danger">*</span></label>
                        <select name="brandid" class="form-select" required>
                            <option value="">-- Chọn Thương Hiệu --</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->brandname }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-success px-4 mt-3">Lưu dữ liệu</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary px-4 mt-3 ms-2">Hủy</a>
            </form>
        </div>
    </div>
@endsection
