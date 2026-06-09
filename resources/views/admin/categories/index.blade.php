@extends('admin.layouts.admin') {{-- thừa kế layout/view admin.blade.php --}}

@section('title', 'Loại Sản phẩm') {{-- Gán nội dung cho vùng section 'title' --}}

@section('content') {{-- Gán nội dung cho vùng section 'content' --}}
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-12">
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
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                                @if (count($list) > 0)
                                    @foreach ($list as $key => $item)
                                        <tr>
                                            {{-- Sử dụng $list->firstItem() để STT tính tiếp tục khi qua trang mới --}}
                                            <td class="text-center fw-bold">{{ $list->firstItem() + $key }}</td>

                                            <td class="text-center">
                                                <img src="{{ $item->image ? asset('images/' . $item->image) : asset('images/default.png') }}"
                                                    class="img-thumbnail"
                                                    style="max-height: 50px; max-width: 80px; object-fit: cover;"
                                                    alt="img">
                                            </td>

                                            <td class="text-center text-secondary fw-bold">{{ $item->cateid }}</td>
                                            <td class="fw-bold text-dark">{{ $item->catename }}</td>
                                            <td><code class="text-secondary">{{ $item->slug }}</code></td>

                                            <td class="text-center">
                                                @if ($item->status == 1)
                                                    <span class="badge bg-success px-2 py-1">Hiển thị</span>
                                                @else
                                                    <span class="badge bg-danger px-2 py-1">Ẩn</span>
                                                @endif
                                            </td>

                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="{{ route('admin.categories.edit', $item->cateid) }}"
                                                        class="btn btn-sm btn-warning d-inline-flex align-items-center gap-1">
                                                        <i class="bi bi-pencil-square"></i> Sửa
                                                    </a>

                                                    <form action="{{ route('admin.categories.destroy', $item->cateid) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa loại sản phẩm này?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-sm btn-danger d-inline-flex align-items-center gap-1">
                                                            <i class="bi bi-trash"></i> Xóa
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">Không có dữ liệu loại sản
                                            phẩm nào.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $list->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
