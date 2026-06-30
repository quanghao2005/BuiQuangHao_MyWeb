@extends('admin.layouts.admin')

@section('title', 'Thương hiệu')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded h-100 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0 text-uppercase fw-bold text-primary">Danh sách Thương hiệu</h5>
                <a href="{{ route('admin.brands.create') }}" class="btn btn-sm btn-success px-3">
                    <i class="bi bi-plus-lg me-2"></i>Thêm mới
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th style="width: 70px;">STT</th>
                            <th style="width: 120px;">ID</th>
                            <th>Tên thương hiệu</th>
                            <th style="width: 120px;">Hình ảnh</th>
                            <th>Slug</th>
                            <th style="width: 150px;">Trạng thái</th>
                            <th style="width: 150px;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($list as $key => $item)
                            <tr>
                                <td class="text-center fw-bold">{{ $list->firstItem() + $key }}</td>
                                <td class="text-center fw-bold text-secondary">{{ $item->brandid }}</td>
                                <td class="fw-bold">{{ $item->brandname }}</td>
                                <td class="text-center">
                                    @if ($item->image)
                                        <img src="{{ asset('storage/brands/' . $item->image) }}" width="60" alt="{{ $item->brandname }}">
                                    @else
                                        <img src="{{ asset('images/banner1.jpg') }}" width="60" alt="Default">
                                    @endif
                                </td>
                                <td><code>{{ $item->slug }}</code></td>
                                <td class="text-center">
                                    @if ($item->status == 1)
                                        <span class="badge bg-success px-2">Hiển thị</span>
                                    @else
                                        <span class="badge bg-danger px-2">Ẩn</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.brands.edit', $item->brandid) }}"
                                        class="btn btn-sm btn-warning">Sửa</a>

                                    <form action="{{ route('admin.brands.destroy', $item->brandid) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Xóa thương hiệu này?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Không có dữ liệu</td>
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
