@extends('admin.layouts.admin')

@section('content')
<div class="card bg-white shadow-sm border-0 rounded-3">
    <div class="card-header bg-white py-3">
        <h4 class="mb-0 text-uppercase fw-bold text-secondary">Danh sách Banner</h4>
        <a href="{{ route('admin.banners.create') }}" class="btn btn-primary mt-3"><i class="bi bi-plus-circle me-1"></i> Thêm mới</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th width="50">ID</th>
                        <th width="200">Hình ảnh</th>
                        <th>Tiêu đề</th>
                        <th>Đường dẫn</th>
                        <th width="100">Thứ tự</th>
                        <th width="120">Trạng thái</th>
                        <th width="150">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($banners as $banner)
                    <tr>
                        <td class="text-center">{{ $banner->bannerid }}</td>
                        <td class="text-center">
                            @if($banner->image)
                                <img src="{{ asset('storage/' . $banner->image) }}" alt="Banner" class="img-fluid rounded shadow-sm" style="max-height: 80px; object-fit: cover;">
                            @else
                                <span class="text-muted">Không có ảnh</span>
                            @endif
                        </td>
                        <td>{{ $banner->title ?? 'Không có tiêu đề' }}</td>
                        <td>{{ $banner->link ?? '#' }}</td>
                        <td class="text-center">{{ $banner->order }}</td>
                        <td class="text-center">
                            @if($banner->status == 1)
                                <span class="badge bg-success">Hiển thị</span>
                            @else
                                <span class="badge bg-danger">Đang ẩn</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.banners.edit', $banner->bannerid) }}" class="btn btn-sm btn-warning text-white shadow-sm mb-1"><i class="bi bi-pencil-square me-1"></i>Sửa</a>
                            <form action="{{ route('admin.banners.destroy', $banner->bannerid) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa banner này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger shadow-sm"><i class="bi bi-trash me-1"></i>Xóa</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">Chưa có banner nào trong hệ thống.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
