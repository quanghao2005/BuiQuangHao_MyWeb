@extends('admin.layouts.admin')

@section('title', 'Danh sách người dùng')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded p-4">
            <h5 class="mb-4">Danh sách người dùng</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Họ tên</th>
                            <th>Email</th>
                            <th>Ngày tạo</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->fullname }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>
                                    <span class="badge {{ $item->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                        {{ $item->status == 1 ? 'Hoạt động' : 'Khóa' }}
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('admin.users.destroy', $item->id) }}" method="POST" ...>
                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
@endsection
