@extends('admin.layouts.admin')

@section('content')
<div class="card bg-white shadow-sm border-0 rounded-3">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h4 class="mb-0 text-uppercase fw-bold text-secondary">Thêm mới Banner</h4>
        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i> Quay lại</a>
    </div>
    <div class="card-body p-4">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tiêu đề (Tùy chọn)</label>
                        <input type="text" name="title" class="form-control" placeholder="Nhập tiêu đề banner" value="{{ old('title') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Mô tả ngắn (Tùy chọn)</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Nhập mô tả banner">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Đường dẫn liên kết (Tùy chọn)</label>
                        <input type="text" name="link" class="form-control" placeholder="https://..." value="{{ old('link') }}">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Hình ảnh <span class="text-danger">*</span></label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Thứ tự hiển thị</label>
                        <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}" min="0">
                        <small class="text-muted">Số càng nhỏ, xếp càng trước.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Trạng thái</label>
                        <select name="status" class="form-select">
                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Hiển thị</option>
                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Ẩn</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold"><i class="bi bi-save me-1"></i> Lưu Banner</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
