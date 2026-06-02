@extends('admin.layouts.admin')

@section('title', 'Quản lý Thương hiệu')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded p-4">
            <h5 class="mb-4">Danh sách thương hiệu</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Ảnh</th>
                        <th>Mã thương hiệu</th>
                        <th>Tên thương hiệu</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><img src="{{ asset('images/' . $item->image) }}" width="50"></td>
                            <td>{{ $item->brandid }}</td>
                            <td>{{ $item->brandname }}</td>
                            <td>{{ $item->status == 1 ? 'Hiển thị' : 'Ẩn' }}</td>
                            <td>
                                <form action="{{ route('admin.brands.destroy', $item->brandid) }}" method="POST"
                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
