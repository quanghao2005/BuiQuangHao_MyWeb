@extends('admin.layouts.admin')
@section('title', 'Đổi Mật Khẩu')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-light rounded p-4 w-75 mx-auto">
        <h4 class="mb-4 text-primary fw-bold text-uppercase text-center">Đổi Mật Khẩu</h4>
        
        <x-admin.alert />

        <form action="{{ route('changepass.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold">Mật khẩu cũ <span class="text-danger">*</span></label>
                <input type="password" name="old_password" class="form-control @error('old_password') is-invalid @enderror" placeholder="Nhập mật khẩu hiện tại...">
                @error('old_password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Mật khẩu mới <span class="text-danger">*</span></label>
                <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" placeholder="Nhập mật khẩu mới (ít nhất 6 ký tự)...">
                @error('new_password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Xác nhận mật khẩu mới <span class="text-danger">*</span></label>
                <input type="password" name="confirm_password" class="form-control @error('confirm_password') is-invalid @enderror" placeholder="Nhập lại mật khẩu mới...">
                @error('confirm_password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary px-5 py-2 fw-bold">Lưu thay đổi</button>
            </div>
        </form>
    </div>
</div>
@endsection
