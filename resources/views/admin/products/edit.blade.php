@extends('admin.layouts.admin')
@section('title', 'Sửa Sản Phẩm')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded p-4">
            <h3 class="mb-4 text-primary text-uppercase fw-bold">Sửa Sản Phẩm</h3>

            {{-- Hiển thị lỗi từ session flash --}}
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Hiển thị lỗi Validation --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tên sản phẩm <span class="text-danger">*</span></label>
                            <input type="text" name="productname" class="form-control"
                                value="{{ old('productname', $product->productname) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Slug <span class="text-danger">*</span></label>
                            <input type="text" name="slug" class="form-control"
                                value="{{ old('slug', $product->slug) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Danh mục <span class="text-danger">*</span></label>
                            <select name="cateid" class="form-select" required>
                                <option value="">-- Chọn Danh Mục --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->cateid }}"
                                        {{ old('cateid', $product->cateid) == $category->cateid ? 'selected' : '' }}>
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
                                    {{-- Đã dùng $brand->brandid để fix lỗi Validation hôm trước --}}
                                    <option value="{{ $brand->brandid }}"
                                        {{ old('brandid', $product->brandid) == $brand->brandid ? 'selected' : '' }}>
                                        {{ $brand->brandname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Giá bán (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" name="price" class="form-control"
                                value="{{ old('price', $product->price) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Giá khuyến mãi</label>
                            <input type="number" name="pricediscount" class="form-control"
                                value="{{ old('pricediscount', $product->pricediscount) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block fw-bold">Trạng thái <span class="text-danger">*</span></label>
                            <div class="d-flex align-items-center">
                                <input type="radio" class="btn-check" name="status" id="active" value="1" {{ old('status', $product->status) == 1 ? 'checked' : '' }}>
                                <label class="btn btn-success" for="active">Hiển thị</label>

                                <input type="radio" class="btn-check" name="status" id="inactive" value="0" {{ old('status', $product->status) == 0 ? 'checked' : '' }}>
                                <label class="btn btn-outline-danger ms-1" for="inactive">Ẩn</label>

                                @error('status')
                                    <span class="text-danger ms-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Mô tả sản phẩm</label>
                            <textarea name="description" rows="4" class="form-control">{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div class="mb-3 img-group">
                            <label class="form-label fw-bold">Hình ảnh chính</label>
                            <input type="file" name="img" class="form-control img-input">
                            <div class="img-preview mt-2">
                                @if ($product->image)
                                    <img src="{{ asset('storage/products/' . $product->image) }}" class="img-thumbnail" width="120">
                                @endif
                            </div>
                            @error('img')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3 img-group">
                            <label class="form-label fw-bold">Hình ảnh phụ</label>
                            <input type="file" name="imgs[]" class="form-control img-input" multiple>
                            <div class="img-preview mt-2 d-flex flex-wrap" id="sub-images-container">
                                @foreach ($product->images as $image)
                                    <div class="position-relative me-2 mb-2 sub-image-item" id="img-{{ $image->id }}">
                                        <img src="{{ asset('storage/products/' . $image->image) }}" class="img-thumbnail" width="100">
                                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 p-0 px-1 delete-sub-img" data-id="{{ $image->id }}">
                                            &times;
                                        </button>
                                    </div>
                                @endforeach
                            </div>
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

@push('scripts')
<script>
    document.querySelectorAll('.delete-sub-img').forEach(btn => {
        btn.addEventListener('click', function() {
            if(!confirm('Xóa ảnh phụ này?')) return;
            const id = this.getAttribute('data-id');
            const url = '{{ url("admin/products/delete-image") }}/' + id;
            
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    document.getElementById('img-' + id).remove();
                } else {
                    alert('Lỗi khi xóa ảnh');
                }
            })
            .catch(error => console.error(error));
        });
    });
</script>
@endpush
