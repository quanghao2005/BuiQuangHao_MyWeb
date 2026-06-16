@extends('admin.layouts.admin')
@section('title', 'Danh sách Bài viết')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0 text-primary fw-bold text-uppercase">Danh Sách Bài Viết</h5>
                <a href="{{ route('admin.posts.create') }}" class="btn btn-sm btn-success px-3"><i class="bi bi-plus"></i> Thêm
                    mới</a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th width="50">ID</th>
                            <th>Hình ảnh</th>
                            <th>Tiêu đề bài viết</th>
                            <th>Tác giả</th>
                            <th>Loại (Type)</th>
                            <th>Trạng thái</th>
                            <th width="150">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($list as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>
                                    <img src="{{ asset('images/banner1.jpg') }}" width="60">
                                </td>
                                <td class="text-start fw-bold">{{ $item->title }}</td>

                                <td class="text-primary">{{ $item->user?->fullname ?? 'Khách' }}</td>

                                <td>{{ $item->type }}</td>
                                <td>
                                    @if ($item->status == 1)
                                        <span class="badge bg-success">Hiển thị</span>
                                    @else
                                        <span class="badge bg-danger">Ẩn</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.posts.edit', $item->id) }}"
                                        class="btn btn-sm btn-warning">Sửa</a>
                                    <form action="{{ route('admin.posts.destroy', $item->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Chắc chắn xóa?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-muted">Không có dữ liệu bài viết</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-3">
                {{ $list->links() }}
            </div>
        </div>
    </div>
@endsection
