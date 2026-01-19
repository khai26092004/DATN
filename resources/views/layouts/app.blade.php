<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cây Cảnh Shop')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">KPlantHouse</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="/">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="/products">Sản phẩm</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">Giới thiệu</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Liên hệ</a></li>
                    <li class="nav-item"><a class="nav-link" href="/cart">Giỏ hàng</a></li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('profile.index') }}">Hồ sơ</a></li>
                                <li><a class="dropdown-item" href="{{ route('orders.index') }}">Đơn hàng</a></li>
                                @if(Auth::user()->role === 'admin')
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="/admin">Quản trị</a></li>
                                @endif
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Đăng xuất</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Đăng nhập</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Đăng ký</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @yield('content')
    </div>

    <!-- Footer -->
    <!-- Footer -->
    <footer class="footer-custom">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5><i class="fas fa-leaf me-2"></i>KPlantHouse</h5>
                    <p class="text-white-50">Mang hơi thở thiên nhiên vào không gian sống của bạn. Chúng tôi cam kết
                        cung cấp những chậu cây khỏe mạnh nhất với dịch vụ tận tâm.</p>
                    <div class="social-icons mt-3">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-pinterest"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 mb-4">
                    <h5>Liên kết nhanh</h5>
                    <ul class="list-unstyled footer-links">
                        <li><a href="/"><i class="fas fa-angle-right me-2"></i>Trang chủ</a></li>
                        <li><a href="{{ route('products.index') }}"><i class="fas fa-angle-right me-2"></i>Sản phẩm</a>
                        </li>
                        <li><a href="{{ route('about') }}"><i class="fas fa-angle-right me-2"></i>Giới thiệu</a></li>
                        <li><a href="{{ route('contact') }}"><i class="fas fa-angle-right me-2"></i>Liên hệ</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <h5>Liên hệ</h5>
                    <ul class="list-unstyled footer-links text-white-50">
                        <li class="mb-3"><i class="fas fa-map-marker-alt me-2 text-warning"></i> 123 Đường Cây Xanh, Hà
                            Nội</li>
                        <li class="mb-3"><i class="fas fa-phone me-2 text-warning"></i> 0912 345 678</li>
                        <li class="mb-3"><i class="fas fa-envelope me-2 text-warning"></i> contact@kplanthouse.vn</li>
                        <li><i class="fas fa-clock me-2 text-warning"></i> 8:00 - 20:00 (Hàng ngày)</li>
                    </ul>
                </div>


                <div class="col-lg-3 col-md-6 mb-4">
                    <h5>Đăng ký nhận tin</h5>
                    <p class="text-white-50 small">Nhận thông tin ưu đãi mới nhất.</p>
                    <form onsubmit="event.preventDefault(); alert('Cảm ơn bạn đã đăng ký!');">
                        <div class="input-group mb-3">
                            <input type="email" class="form-control newsletter-input" placeholder="Email của bạn..."
                                required>
                            <button class="btn btn-warning" type="submit"><i class="fas fa-paper-plane"></i></button>
                        </div>
                    </form>
                </div>
            </div>

            <hr class="border-secondary my-4">

            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 text-white-50">© 2025 KPlantHouse. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">

                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>

</html>