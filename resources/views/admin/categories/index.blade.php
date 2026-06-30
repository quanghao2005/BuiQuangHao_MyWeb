@extends('admin.layouts.admin')
@section('title', 'Loại Sản phẩm')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded h-100 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0 text-uppercase fw-bold text-primary h5">DANH SÁCH LOẠI SẢN PHẨM</h2>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-success px-3">
                    <i class="bi bi-plus-lg me-2"></i>Thêm mới
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped align-middle mb-0">
                    <thead class="table-dark text-center">
                        <tr>
                            <th style="width: 70px;">STT</th>
                            <th style="width: 100px;">Hình ảnh</th>
                            <th style="width: 120px;">Mã loại</th>
                            <th>Tên loại</th>
                            <th>Slug</th>
                            <th style="width: 150px;">Trạng thái</th>
                            <th style="width: 180px;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @forelse tự động xử lý nếu $list rỗng --}}
                        @forelse ($list as $key => $item)
                            <tr>
                                <td class="text-center fw-bold">{{ $list->firstItem() + $key }}</td>
                                <td class="text-center">
                                    @if ($item->image)
                                        <img src="{{ asset('storage/categories/' . $item->image) }}" width="60" alt="{{ $item->catename }}">
                                    @else
                                        <img src="{{ asset('images/banner1.jpg') }}" width="60" alt="Default">
                                    @endif
                                </td>
                                <td class="text-center text-secondary fw-bold">{{ $item->cateid }}</td>
                                <td class="fw-bold text-dark">{{ $item->catename }}</td>
                                <td><code class="text-secondary">{{ $item->slug }}</code></td>
                                <td class="text-center">
                                    <span class="badge {{ $item->status == 1 ? 'bg-success' : 'bg-danger' }} px-2 py-1">
                                        {{ $item->status == 1 ? 'Hiển thị' : 'Ẩn' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('admin.categories.edit', $item->cateid) }}"
                                            class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil-square"></i> Sửa
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $item->cateid) }}"
                                            method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i> Xóa
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Không có dữ liệu loại sản phẩm.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $list->links() }}
            </div>
        </div>
    </div>
@endsection
