@extends('admin.layouts.admin')
@section('title', 'Danh sách Sản phẩm')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0 text-primary fw-bold text-uppercase">Danh sách Sản phẩm</h5>
                <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-success px-3">
                    <i class="bi bi-plus-lg me-2"></i>Thêm mới
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>STT</th>
                            <th>Ảnh</th>
                            <th>Tên Sản Phẩm</th>
                            <th>Danh mục</th>
                            <th>Thương hiệu</th>
                            <th>Giá</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($list as $key => $item)
                            <tr>
                                <td class="text-center">{{ $list->firstItem() + $key }}</td>
                                <td class="text-center">
                                    <img src="{{ asset('images/' . ($item->image ?? 'default.png')) }}" width="60"
                                        alt="img" style="object-fit: cover;">
                                </td>
                                <td class="fw-bold">{{ $item->productname }}</td>

                                <td>{{ $item->category?->catename ?? 'Không có' }}</td>

                                <td>{{ $item->brand?->brandname ?? 'Chưa có' }}</td>

                                <td class="text-end">{{ number_format($item->price) }} đ</td>

                                <td class="text-center">
                                    <a href="{{ route('admin.products.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i> Sửa
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $item->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i> Xóa
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Không có dữ liệu sản phẩm.</td>
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
