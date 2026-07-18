@extends('admin.layouts.admin') 
@section('title', 'Loại Sản phẩm')

@section('content')
    <div class="border rounded bg-white p-4 shadow-sm m-4">
        <h3 class="mb-4">Thêm loại sản phẩm</h3>

        {{-- Gọi component alert --}}
        <x-admin.alert />

        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Tên loại sản phẩm</label>
                        <input type="text" name="catename" class="form-control" value="{{ old('catename') }}" required>
                        {{-- hiển thị lỗi cho trường catename --}}
                        @error('catename')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Slug</label>
                        <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" required>
                        {{-- hiển thị lỗi cho trường slug --}}
                        @error('slug')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3 img-group">
                        <label class="form-label">Hình ảnh</label>
                        <input type="file" name="img" class="form-control img-input">
                        <div class="img-preview mt-2"></div>
                        @error('img')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label d-block fw-bold">Trạng thái <span class="text-danger">*</span></label>
                        <div class="d-flex align-items-center">
                            <input type="radio" class="btn-check" name="status" id="active" value="1" {{ old('status') === '1' ? 'checked' : '' }}>
                            <label class="btn btn-success" for="active">Hiển thị</label>

                            <input type="radio" class="btn-check" name="status" id="inactive" value="0" {{ old('status') === '0' ? 'checked' : '' }}>
                            <label class="btn btn-outline-danger ms-1" for="inactive">Ẩn</label>

                            @error('status')
                                <span class="text-danger ms-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Lưu</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary mt-3">Quay lại</a>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.querySelector('input[name="catename"]');
        const slugInput = document.querySelector('input[name="slug"]');

        if (nameInput && slugInput) {
            nameInput.addEventListener('keyup', function() {
                let text = this.value;
                slugInput.value = text.toString().toLowerCase()
                    .replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a')
                    .replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e')
                    .replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i')
                    .replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o')
                    .replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u')
                    .replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y')
                    .replace(/đ/gi, 'd')
                    .replace(/\s+/g, '-')
                    .replace(/[^\w\-]+/g, '')
                    .replace(/\-\-+/g, '-')
                    .replace(/^-+/, '')
                    .replace(/-+$/, '');
            });
        }
    });
</script>
@endpush
