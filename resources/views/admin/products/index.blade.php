@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid pt-4 px-4">
        <table class="table">
            <thead>
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
                @foreach ($list as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            <img src="{{ asset('images/' . ($item->image ?? 'default.png')) }}" width="60" alt="img">
                        </td>
                        <td>{{ $item->productname }}</td>
                        <td>{{ $item->catename }}</td>
                        <td>{{ $item->brandname ?? 'Chưa có' }}</td>
                        <td>{{ number_format($item->price) }} đ</td>
                        <td>...</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
