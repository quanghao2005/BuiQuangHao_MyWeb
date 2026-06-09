@extends('admin.layouts.admin')
@section('title', 'Sửa Sản Phẩm')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded p-4">
            <h5 class="mb-4 text-primary text-uppercase fw-bold">Cập Nhật Sản Phẩm</h5>
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Tên sản phẩm <span class="text-danger">*</span></label>
                        <input type="text" name="productname" class="form-control" value="{{ $product->productname }}"
                            required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Giá bán (VNĐ) <span class="text-danger">*</span></label>
                        <input type="number" name="price" class="form-control" value="{{ $product->price }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Danh mục <span class="text-danger">*</span></label>
                        <select name="cateid" class="form-select" required>
                            @foreach ($categories as $cate)
                                <option value="{{ $cate->cateid }}"
                                    {{ $product->cateid == $cate->cateid ? 'selected' : '' }}>
                                    {{ $cate->catename }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Thương hiệu <span class="text-danger">*</span></label>
                        <select name="brandid" class="form-select" required>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" {{ $product->brandid == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->brandname }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Trạng thái</label>
                        <select name="status" class="form-select">
                            <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Hiển thị</option>
                            <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Ẩn</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-warning px-4 mt-3">Cập nhật</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary px-4 mt-3 ms-2">Hủy</a>
            </form>
        </div>
    </div>
@endsection
