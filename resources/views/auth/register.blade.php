@extends('layouts.app')

@section('title', 'Đăng ký - PlantShop')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="text-center mb-4">
                    <i class="fas fa-seedling fa-3x text-success mb-3"></i>
                    <h2 class="fw-bold">Tạo tài khoản mới</h2>
                    <p class="text-muted">Tham gia cùng chúng tôi ngay hôm nay</p>
                </div>
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">
                        <form action="{{ route('register') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold">Họ và tên</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i
                                            class="fas fa-user text-muted"></i></span>
                                    <input type="text" name="name" class="form-control bg-light border-start-0 ps-0"
                                        value="{{ old('name') }}" placeholder="Nguyễn Văn A" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i
                                            class="fas fa-envelope text-muted"></i></span>
                                    <input type="email" name="email" class="form-control bg-light border-start-0 ps-0"
                                        value="{{ old('email') }}" placeholder="name@example.com" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Mật khẩu</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i
                                            class="fas fa-lock text-muted"></i></span>
                                    <input type="password" name="password" class="form-control bg-light border-start-0 ps-0"
                                        placeholder="••••••••" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold">Xác nhận mật khẩu</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i
                                            class="fas fa-check-circle text-muted"></i></span>
                                    <input type="password" name="password_confirmation"
                                        class="form-control bg-light border-start-0 ps-0" placeholder="••••••••" required>
                                </div>
                            </div>
                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-success btn-lg rounded-pill fw-bold shadow-sm">Đăng
                                    ký</button>
                            </div>
                            <div class="text-center">
                                <p class="mb-0 text-muted small">Đã có tài khoản? <a href="{{ route('login') }}"
                                        class="text-success fw-bold text-decoration-none">Đăng nhập</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection