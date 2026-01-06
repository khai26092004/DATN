@extends('layouts.app')

@section('title', $product->name . ' - PlantShop')

@section('content')
    <div class="card shadow-sm border-0 mb-5 overflow-hidden">
        <div class="row g-0">
            <div class="col-md-6 bg-light d-flex align-items-center justify-content-center p-4">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded shadow-sm"
                        alt="{{ $product->name }}" style="max-height: 500px; object-fit: contain;">
                @else
                    <img src="https://via.placeholder.com/600x400" class="img-fluid rounded shadow-sm" alt="No Image">
                @endif
            </div>
            <div class="col-md-6">
                <div class="card-body p-5 d-flex flex-column h-100 justify-content-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent p-0 mb-3">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}"
                                    class="text-decoration-none text-muted">Trang chủ</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('products.index') }}"
                                    class="text-decoration-none text-muted">Sản phẩm</a></li>
                            <li class="breadcrumb-item active text-dark fw-bold" aria-current="page">{{ $product->name }}
                            </li>
                        </ol>
                    </nav>

                    <h1 class="fw-bold display-5 mb-2">{{ $product->name }}</h1>
                    <p class="text-muted mb-4 fs-5">Danh mục: <a
                            href="{{ route('products.index', ['category' => $product->category->slug]) }}"
                            class="text-success text-decoration-none fw-bold">{{ $product->category->name }}</a></p>

                    <h2 class="text-success fw-bold mb-4 display-6">{{ number_format($product->price) }} VNĐ</h2>

                    <div class="mb-4">
                        <p class="lead" style="font-size: 1rem; color: #555;">{{ $product->description }}</p>
                    </div>

                    <hr class="my-4 opacity-10">

                    <form action="{{ route('cart.add') }}" method="POST" class="mb-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="d-flex align-items-center gap-3">
                            <div class="input-group" style="width: 170px;">
                                <button type="button" class="btn btn-white border border-end-0 btn-decrement">
                                    <i class="fas fa-minus small"></i>
                                </button>
                                <input type="text" name="quantity"
                                    class="form-control text-center border-start-0 border-end-0 fw-bold quantity-input"
                                    value="1" min="1" max="{{ $product->stock_quantity }}">
                                <button type="button" class="btn btn-white border border-start-0 btn-increment">
                                    <i class="fas fa-plus small"></i>
                                </button>
                            </div>
                            <button type="submit" class="btn btn-success btn-lg flex-grow-1 shadow-sm" {{ $product->stock_quantity == 0 ? 'disabled' : '' }}>
                                <i class="fas fa-cart-plus me-2"></i>
                                {{ $product->stock_quantity > 0 ? 'Thêm vào giỏ' : 'Hết hàng' }}
                            </button>
                        </div>
                    </form>

                    <div class="d-flex align-items-center gap-4 text-muted small">
                        <div><i class="fas fa-check-circle text-success me-1"></i> Giao hàng miễn phí</div>
                        <div><i class="fas fa-check-circle text-success me-1"></i> Bảo hành 30 ngày</div>
                        <div>
                            <strong>Tình trạng:</strong>
                            @if($product->stock_quantity > 0)
                                <span class="text-success fw-bold">Còn hàng</span>
                            @else
                                <span class="text-danger fw-bold">Hết hàng</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($relatedProducts->count() > 0)
        <div class="mt-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold text-uppercase border-start border-4 border-success ps-3 mb-0">Sản phẩm liên quan</h3>
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill">Xem tất cả</a>
            </div>

            <div class="row">
                @foreach($relatedProducts as $related)
                    <div class="col-md-3 mb-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <a href="{{ route('products.show', $related->slug) }}" class="overflow-hidden">
                                @if($related->image)
                                    <img src="{{ asset('storage/' . $related->image) }}" class="card-img-top" alt="{{ $related->name }}"
                                        style="height: 180px; object-fit: cover; transition: transform 0.3s;">
                                @else
                                    <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="No Image">
                                @endif
                            </a>
                            <div class="card-body p-3 text-center">
                                <h6 class="card-title text-truncate mb-2">
                                    <a href="{{ route('products.show', $related->slug) }}"
                                        class="text-decoration-none text-dark fw-bold">{{ $related->name }}</a>
                                </h6>
                                <p class="text-danger fw-bold mb-0">{{ number_format($related->price) }} VNĐ</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <style>
        .card-img-top:hover {
            transform: scale(1.05);
        }
    </style>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            // Function to validate numeric input
            function validateInput(input) {
                var value = parseInt(input.val());
                var max = input.attr('max') ? parseInt(input.attr('max')) : 1000;
                var min = input.attr('min') ? parseInt(input.attr('min')) : 1;

                if (isNaN(value)) {
                    input.val(min);
                } else if (value < min) {
                    input.val(min);
                } else if (value > max) {
                    input.val(max);
                } else {
                    input.val(value); // Clean up formatting (e.g. 01 -> 1)
                }
            }

            // Input validation: Only allow numbers
            $(document).off('input', '.quantity-input').on('input', '.quantity-input', function () {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            // Validate on blur
            $(document).off('blur', '.quantity-input').on('blur', '.quantity-input', function () {
                validateInput($(this));
            });

            // Increment button
            $(document).off('click', '.btn-increment').on('click', '.btn-increment', function (e) {
                e.preventDefault();
                var input = $(this).closest('.input-group').find('.quantity-input');
                var currentVal = parseInt(input.val()) || 0;
                var max = input.attr('max') ? parseInt(input.attr('max')) : 1000;

                if (currentVal < max) {
                    input.val(currentVal + 1);
                }
            });

            // Decrement button
            $(document).off('click', '.btn-decrement').on('click', '.btn-decrement', function (e) {
                e.preventDefault();
                var input = $(this).closest('.input-group').find('.quantity-input');
                var currentVal = parseInt(input.val()) || 0;
                var min = input.attr('min') ? parseInt(input.attr('min')) : 1;

                if (currentVal > min) {
                    input.val(currentVal - 1);
                }
            });
        });
    </script>
@endsection