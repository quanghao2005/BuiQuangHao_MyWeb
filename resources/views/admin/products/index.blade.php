@extends('admin.layouts.admin')
@section('title', 'Danh sách Sản phẩm')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded p-4">

            {{-- Tiêu đề và nút thêm mới theo đúng hướng dẫn Lab --}}
            <h2 class="mb-3 text-uppercase fw-bold">Danh sách Sản phẩm</h2>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-3">
                <i class="bi bi-plus-circle"></i> Thêm mới
            </a>

            {{-- Hiển thị thông báo thành công từ session flash 'success' --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Table hiển thị dữ liệu --}}
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>STT</th>
                            <th style="width: 100px;">Ảnh</th>
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
                                    @if ($item->image)
                                        <img src="{{ asset('storage/products/' . $item->image) }}" alt="{{ $item->productname }}" class="img-fluid rounded mb-3" style="max-height: 80px;">
                                    @else
                                        <img src="{{ asset('images/banner1.jpg') }}" alt="Default" class="img-fluid rounded mb-3">
                                    @endif
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
                                        @csrf
                                        @method('DELETE')
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

            {{-- Phân trang --}}
            <div class="d-flex justify-content-center mt-3">
                {{ $list->links() }}
            </div>

        </div>
    </div>
@endsection
