@extends('layouts.app')

@section('title', $product->name . ' - KPlantHouse')

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
                    <p class="text-muted mb-4 fs-5">Danh mục:
                        @foreach($product->categories as $category)
                            <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                                class="text-success text-decoration-none fw-bold">{{ $category->name }}</a>{{ !$loop->last ? ', ' : '' }}
                        @endforeach
                    </p>

                    <h2 class="text-success fw-bold mb-4 display-6">{{ number_format($product->price) }} VNĐ</h2>



                    @if($product->characteristics || $product->light || $product->watering || $product->usage || $product->meaning)
                    <div class="mb-4">
                        <h5 class="fw-bold text-success mb-3"><i class="fas fa-info-circle me-2"></i>Chi tiết sản phẩm</h5>
                        <table class="table table-bordered table-sm">
                            <tbody>
                                @if($product->characteristics)
                                <tr>
                                    <th class="bg-light px-3 py-2" style="width: 150px;">Đặc điểm</th>
                                    <td class="px-3 py-2">{!! nl2br(e($product->characteristics)) !!}</td>
                                </tr>
                                @endif
                                @if($product->light)
                                <tr>
                                    <th class="bg-light px-3 py-2">Ánh sáng</th>
                                    <td class="px-3 py-2">{!! nl2br(e($product->light)) !!}</td>
                                </tr>
                                @endif
                                @if($product->watering)
                                <tr>
                                    <th class="bg-light px-3 py-2">Tưới nước</th>
                                    <td class="px-3 py-2">{!! nl2br(e($product->watering)) !!}</td>
                                </tr>
                                @endif
                                @if($product->usage)
                                <tr>
                                    <th class="bg-light px-3 py-2">Công dụng</th>
                                    <td class="px-3 py-2">{!! nl2br(e($product->usage)) !!}</td>
                                </tr>
                                @endif
                                @if($product->meaning)
                                <tr>
                                    <th class="bg-light px-3 py-2">Ý nghĩa</th>
                                    <td class="px-3 py-2">{!! nl2br(e($product->meaning)) !!}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    @endif

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
                        <div class="card h-100 border-0 shadow-sm transition-hover">
                            <a href="{{ route('products.show', $related->slug) }}" class="position-relative overflow-hidden">
                                @if($related->image)
                                    <img src="{{ asset('storage/' . $related->image) }}" class="card-img-top" alt="{{ $related->name }}"
                                        style="height: 220px; object-fit: cover; transition: transform 0.5s;">
                                @else
                                    <img src="https://via.placeholder.com/300x220" class="card-img-top" alt="No Image">
                                @endif
                                <div class="overlay d-flex align-items-center justify-content-center position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-25 opacity-0 hover-opacity-100 transition-opacity">
                                    <span class="btn btn-light rounded-circle shadow"><i class="fas fa-eye"></i></span>
                                </div>
                            </a>
                            <div class="card-body">
                                <h6 class="card-title text-truncate mb-2">
                                    <a href="{{ route('products.show', $related->slug) }}"
                                        class="text-decoration-none text-dark fw-bold hover-text-success">{{ $related->name }}</a>
                                </h6>
                                <p class="card-text text-danger fw-bold">{{ number_format($related->price) }} VNĐ</p>
                            </div>
                            <div class="card-footer bg-white border-top-0 d-grid pb-3">
                                <a href="{{ route('products.show', $related->slug) }}" class="btn btn-outline-success rounded-pill btn-sm"><i class="fas fa-cart-plus me-1"></i> Mua ngay</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Review Section -->
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h3 class="fw-bold text-uppercase border-start border-4 border-success ps-3 mb-0">Đánh giá sản phẩm</h3>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <!-- Review Summary & List -->
                        <div class="col-md-7">
                            <div class="d-flex align-items-center mb-4">
                                <div class="bg-light rounded p-3 text-center me-3" style="min-width: 100px;">
                                    <h1 class="fw-bold text-success mb-0">{{ number_format($product->reviews->avg('rating'), 1) }}</h1>
                                    <div class="small text-warning">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= round($product->reviews->avg('rating')) ? '' : 'text-muted' }}"></i>
                                        @endfor
                                    </div>
                                    <small class="text-muted">{{ $product->reviews->count() }} đánh giá</small>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1">Khách hàng nói gì?</h5>
                                    <p class="text-muted mb-0 small">Tổng hợp nhận xét từ khách hàng đã mua sản phẩm.</p>
                                </div>
                            </div>

                            <hr class="opacity-10 mb-4">

                            @forelse($product->reviews as $review)
                                <div class="d-flex mb-4">
                                    <div class="flex-shrink-0">
                                        <div class="avatar bg-success text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 50px; height: 50px; font-size: 1.2rem;">
                                            {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="fw-bold mb-0">{{ $review->user->name }}</h6>
                                                <div class="text-warning small mb-1">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star {{ $i <= $review->rating ? '' : 'text-muted' }}"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                            <small class="text-muted bg-light px-2 py-1 rounded">{{ $review->created_at->format('d/m/Y') }}</small>
                                        </div>
                                        <p class="mb-0 text-secondary" style="font-size: 0.95rem;">{{ $review->comment }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <i class="far fa-comment-dots fa-3x text-muted mb-3 opacity-50"></i>
                                    <p class="text-muted">Chưa có đánh giá nào. Hãy là người đầu tiên!</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Review Form -->
                        <div class="col-md-5">
                            @auth
                                <div class="card border-0 bg-light rounded-3 p-3 sticky-top" style="top: 100px;">
                                    <div class="card-body">
                                        <h5 class="fw-bold mb-3">Viết đánh giá mới</h5>
                                        <form action="{{ route('reviews.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Chọn mức độ hài lòng</label>
                                                <div class="rating-css">
                                                    <div class="star-icon">
                                                        <input type="radio" value="1" name="rating" checked id="rating1">
                                                        <label for="rating1" class="fa fa-star"></label>
                                                        <input type="radio" value="2" name="rating" id="rating2">
                                                        <label for="rating2" class="fa fa-star"></label>
                                                        <input type="radio" value="3" name="rating" id="rating3">
                                                        <label for="rating3" class="fa fa-star"></label>
                                                        <input type="radio" value="4" name="rating" id="rating4">
                                                        <label for="rating4" class="fa fa-star"></label>
                                                        <input type="radio" value="5" name="rating" id="rating5">
                                                        <label for="rating5" class="fa fa-star"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="comment" class="form-label fw-bold">Nhận xét của bạn</label>
                                                <textarea name="comment" id="comment" rows="4" class="form-control border-0 shadow-sm" placeholder="Sản phẩm dùng thế nào? Chất lượng ra sao..."></textarea>
                                            </div>
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-success shadow-sm fw-bold">Gửi đánh giá</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <div class="card border-0 bg-light rounded-3 p-4 text-center">
                                    <i class="fas fa-lock fa-2x text-muted mb-3"></i>
                                    <h5>Đăng nhập để đánh giá</h5>
                                    <p class="text-muted small">Bạn cần đăng nhập để gửi nhận xét về sản phẩm này.</p>
                                    <a href="{{ route('login') }}" class="btn btn-outline-success rounded-pill px-4">Đăng nhập</a>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .hover-text-success:hover { color: #198754 !important; }
        .card-img-top:hover { transform: scale(1.05); }
        .overlay { opacity: 0; transition: opacity 0.3s; }
        .card:hover .overlay { opacity: 1; }
        
        /* Star Rating CSS */
        .rating-css div {
            color: #ffe400;
            font-size: 20px;
            font-family: sans-serif;
            font-weight: 800;
            text-align: center;
            text-transform: uppercase;
            padding: 10px 0;
        }
        .rating-css input {
            display: none;
        }
        .rating-css input + label {
            font-size: 30px;
            text-shadow: 1px 1px 0 #8f8420;
            cursor: pointer;
        }
        .rating-css input:checked + label ~ label {
            color: #b4b4b4;
        }
        .rating-css label:active {
            transform: scale(0.8);
            transition: 0.3s all;
        }
        /* End Star Rating CSS */
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