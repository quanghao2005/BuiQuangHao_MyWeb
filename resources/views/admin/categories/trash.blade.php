@extends('admin.layouts.admin')
@section('title', 'Trash-Loại Sản phẩm')
@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded h-100 p-4">
            <h2 class="mb-3 text-uppercase fw-bold text-danger h5">DANH SÁCH LOẠI SẢN PHẨM - ĐANG CHỜ XÓA</h2>
            
            <x-admin.alert />

            <a href="{{ route('admin.categories.index') }}" class="btn btn-primary mb-3">
                <i class="bi bi-arrow-left-circle me-1"></i> Quay lại danh sách
            </a>

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
                                    @if ($item->status == 1)
                                        <span class="badge bg-success px-2 py-1">Hiển thị</span>
                                    @else
                                        <span class="badge bg-danger px-2 py-1">Ẩn</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <form action="{{ route('admin.categories.restore', $item->cateid) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success">
                                                Khôi phục
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.categories.forceDelete', $item->cateid) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa vĩnh viễn?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                Xóa
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Thùng rác trống.</td>
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
