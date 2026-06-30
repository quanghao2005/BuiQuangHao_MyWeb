@extends('admin.layouts.admin')
@section('title', 'Thêm Sản Phẩm')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded p-4">
            <h3 class="mb-4 text-primary text-uppercase fw-bold">Thêm Sản Phẩm Mới</h3>

            {{-- Hiển thị lỗi từ session flash 'error' (Catch Exception) --}}
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Hiển thị lỗi Validation (Form Request) --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tên sản phẩm <span class="text-danger">*</span></label>
                            <input type="text" name="productname" class="form-control" value="{{ old('productname') }}"
                                placeholder="VD: iPhone 15 Pro Max" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Slug <span class="text-danger">*</span></label>
                            <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Danh mục <span class="text-danger">*</span></label>
                            <select name="cateid" class="form-select" required>
                                <option value="">-- Chọn Danh Mục --</option>
                                @foreach ($categories as $category)
                                    {{-- LƯU Ý: Nếu bảng categories khóa chính không phải là 'cateid', hãy sửa lại --}}
                                    <option value="{{ $category->cateid }}"
                                        {{ old('cateid') == $category->cateid ? 'selected' : '' }}>
                                        {{ $category->catename }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Thương hiệu <span class="text-danger">*</span></label>
                            <select name="brandid" class="form-select" required>
                                <option value="">-- Chọn Thương Hiệu --</option>
                                @foreach ($brands as $brand)
                                    {{-- Đã đổi $brand->id thành $brand->brandid --}}
                                    <option value="{{ $brand->brandid }}"
                                        {{ old('brandid') == $brand->brandid ? 'selected' : '' }}>
                                        {{ $brand->brandname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Giá bán (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" name="price" class="form-control" value="{{ old('price') }}"
                                min="0" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Giá khuyến mãi (VNĐ)</label>
                            <input type="number" name="pricediscount" class="form-control"
                                value="{{ old('pricediscount', 0) }}" min="0">
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block fw-bold">Trạng thái</label>

                            <input type="radio" class="btn-check" name="status" id="active" value="1"
                                {{ old('status') === '1' ? 'checked' : '' }}>
                            <label class="btn btn-outline-success" for="active">Hiển thị</label>

                            <input type="radio" class="btn-check" name="status" id="inactive" value="0"
                                {{ old('status') === '0' ? 'checked' : '' }}>
                            <label class="btn btn-outline-danger" for="inactive">Ẩn</label>

                            <div class="mt-1">
                                @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Mô tả sản phẩm</label>
                            <textarea name="description" rows="4" class="form-control">{{ old('description') }}</textarea>
                        </div>
                        
                        <div class="mb-3 img-group">
                            <label class="form-label fw-bold">Hình ảnh chính</label>
                            <input type="file" name="img" class="form-control img-input">
                            <div class="img-preview mt-2"></div>
                            @error('img')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3 img-group">
                            <label class="form-label fw-bold">Hình ảnh phụ</label>
                            <input type="file" name="imgs[]" class="form-control img-input" multiple>
                            <div class="img-preview mt-2"></div>
                            @error('imgs.*')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr class="mt-2 mb-3">
                <button type="submit" class="btn btn-primary px-4">Lưu sản phẩm</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary px-4 ms-2">Quay lại</a>
            </form>
        </div>
    </div>
@endsection
s
