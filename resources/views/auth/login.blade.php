@extends('layouts.app')

@section('title', 'Đăng nhập - PlantShop')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="text-center mb-4">
                    <i class="fas fa-leaf fa-3x text-success mb-3"></i>
                    <h2 class="fw-bold">Chào mừng trở lại</h2>
                    <p class="text-muted">Vui lòng đăng nhập để tiếp tục</p>
                </div>
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label fw-bold">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i
                                            class="fas fa-envelope text-muted"></i></span>
                                    <input type="email" name="email" class="form-control bg-light border-start-0 ps-0"
                                        value="{{ old('email') }}" placeholder="name@example.com" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold">Mật khẩu</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i
                                            class="fas fa-lock text-muted"></i></span>
                                    <input type="password" name="password" class="form-control bg-light border-start-0 ps-0"
                                        placeholder="••••••••" required>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mb-4">
                                <div class="form-check">
                                    <label class="form-check-label small" for="remember">Ghi nhớ đăng nhập</label>
                                </div>
                                <a href="#"
                                    class="text-decoration-none small text-success fw-bold">Quên mật khẩu?</a>
                            </div>
                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-success btn-lg rounded-pill fw-bold shadow-sm">Đăng
                                    nhập</button>
                            </div>
                            <div class="text-center">
                                <p class="mb-0 text-muted small">Chưa có tài khoản? <a href="{{ route('register') }}"
                                        class="text-success fw-bold text-decoration-none">Đăng ký ngay</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection