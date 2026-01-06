@extends('layouts.app')

@section('title', 'Trang chủ - PlantShop')

@section('content')
    <!-- Hero Section -->
    <div class="p-5 mb-5 bg-light rounded-3 text-center position-relative overflow-hidden shadow-sm"
        style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ asset('images/image-hero.avif') }}'); background-size: cover; background-position: center; color: white; min-height: 500px; display: flex; align-items: center; justify-content: center;">
        <div class="position-relative z-1">
            <h1 class="display-3 fw-bold mb-3 animate__animated animate__fadeInDown">Mang Thiên Nhiên Vào Nhà</h1>
            <p class="lead mb-4 fs-4 animate__animated animate__fadeInUp animate__delay-1s">Khám phá bộ sưu tập cây cảnh độc
                đáo giúp không gian sống của bạn thêm tươi mới.</p>
            <a href="{{ route('products.index') }}"
                class="btn btn-warning btn-lg px-5 py-3 rounded-pill fw-bold animate__animated animate__fadeInUp animate__delay-2s shadow">Mua
                Ngay <i class="fas fa-arrow-right ms-2"></i></a>
        </div>
    </div>

    <!-- Features -->
    <div class="row text-center mb-5">
        <div class="col-md-4 mb-3">
            <div class="p-4 bg-white rounded shadow-sm h-100">
                <i class="fas fa-shipping-fast fa-3x text-success mb-3"></i>
                <h4>Giao Hàng Nhanh</h4>
                <p class="text-muted">Giao hàng trong nội thành Hà Nội chỉ từ 2 giờ.</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="p-4 bg-white rounded shadow-sm h-100">
                <i class="fas fa-certificate fa-3x text-success mb-3"></i>
                <h4>Cam Kết Chất Lượng</h4>
                <p class="text-muted">Cây khỏe mạnh, được tuyển chọn kỹ lưỡng từ vườn ươm.</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="p-4 bg-white rounded shadow-sm h-100">
                <i class="fas fa-headset fa-3x text-success mb-3"></i>
                <h4>Hỗ Trợ 24/7</h4>
                <p class="text-muted">Đội ngũ chuyên gia sẵn sàng tư vấn chăm sóc cây.</p>
            </div>
        </div>
    </div>

    <!-- Featured Products -->
    <div class="row mb-4 align-items-center">
        <div class="col-12 text-center">
            <h2 class="mb-2 fw-bold text-uppercase" style="color: var(--primary-color);">Sản phẩm nổi bật</h2>
            <div style="width: 60px; height: 3px; background: var(--accent-color); margin: 0 auto 30px;"></div>
        </div>
    </div>

    <div class="row">
        @foreach($featuredProducts as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100 border-0">
                    <a href="{{ route('products.show', $product->slug) }}" class="overflow-hidden position-relative">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top transition-transform"
                                alt="{{ $product->name }}" style="height: 250px; object-fit: cover;">
                        @else
                            <img src="https://via.placeholder.com/300x250" class="card-img-top" alt="No Image">
                        @endif
                        <span class="badge bg-danger position-absolute top-0 end-0 m-2">Hot</span>
                    </a>
                    <div class="card-body text-center">
                        <h5 class="card-title">
                            <a href="{{ route('products.show', $product->slug) }}"
                                class="text-decoration-none text-dark fw-bold hover-primary">{{ $product->name }}</a>
                        </h5>
                        <p class="card-text text-success fw-bold fs-5">{{ number_format($product->price) }} VNĐ</p>
                    </div>
                    <div class="card-footer bg-white border-top-0 d-grid pb-3">
                        <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-success rounded-pill">Xem
                            chi tiết</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


@endsection