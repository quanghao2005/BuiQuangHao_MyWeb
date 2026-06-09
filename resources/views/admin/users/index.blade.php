@extends('admin.layouts.admin')

@section('title', 'Người dùng')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded h-100 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0 text-uppercase fw-bold text-primary">Danh sách Người dùng</h5>
                <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-success px-3">
                    <i class="bi bi-person-plus-fill me-2"></i>Thêm User
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th style="width: 70px;">STT</th>
                            <th>Họ và Tên</th>
                            <th>Email</th>
                            <th>Ngày tạo</th>
                            <th style="width: 150px;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($list as $key => $item)
                            <tr>
                                <td class="text-center fw-bold">{{ $list->firstItem() + $key }}</td>
                                <td class="fw-bold">{{ $item->name }}</td>
                                <td><a href="mailto:{{ $item->email }}">{{ $item->email }}</a></td>
                                <td class="text-center">{{ $item->created_at->format('d/m/Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.users.edit', $item->id) }}"
                                        class="btn btn-sm btn-warning">Sửa</a>
                                    <form action="{{ route('admin.users.destroy', $item->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Chắc chắn xóa user này?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Không có người dùng nào</td>
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
