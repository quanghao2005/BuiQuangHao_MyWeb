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
                        <label class="form-label d-block">Trạng thái</label>
                        <input type="radio" class="btn-check" name="status" id="active" value="1" {{ old('status') === '1' ? 'checked' : '' }}>
                        <label class="btn btn-outline-success" for="active">Hiển thị</label>

                        <input type="radio" class="btn-check" name="status" id="inactive" value="0" {{ old('status') === '0' ? 'checked' : '' }}>
                        <label class="btn btn-outline-danger" for="inactive">Ẩn</label>
                        
                        <div class="mt-1">
                            {{-- hiển thị lỗi cho trường status --}}
                            @error('status')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
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
