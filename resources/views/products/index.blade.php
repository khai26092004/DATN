@extends('layouts.app')

@section('title', 'Danh sách sản phẩm - KPlantHouse')

@section('content')
<div class="row">
    <!-- Sidebar Filters -->
    <div class="col-md-3 mb-4">
        <div class="card shadow-sm border-0 sticky-top" style="top: 80px; z-index: 1;">
            <div class="card-header bg-success text-white rounded-top">
                <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Danh mục</h5>
            </div>
            <div class="list-group list-group-flush rounded-bottom">
                <a href="{{ route('products.index') }}" class="list-group-item list-group-item-action {{ !request('category') ? 'active bg-light text-success fw-bold border-start border-4 border-success' : '' }}">
                    <i class="fas fa-th-large me-2"></i>Tất cả sản phẩm
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('products.index', ['category' => $category->slug]) }}" 
                       class="list-group-item list-group-item-action {{ request('category') == $category->slug ? 'active bg-light text-success fw-bold border-start border-4 border-success' : '' }}">
                        <i class="fas fa-leaf me-2"></i>{{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Product List -->
    <div class="col-md-9">
        <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded shadow-sm">
            <h2 class="mb-0 fs-4 fw-bold text-success">{{ request('category') ? 'Danh mục: ' . request('category') : 'Tất cả sản phẩm' }}</h2>
            <form action="{{ route('products.index') }}" method="GET" class="d-flex">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <div class="input-group">
                    <input class="form-control border-end-0" type="search" name="search" placeholder="Tìm kiếm..." value="{{ request('search') }}">
                    <button class="btn btn-outline-success border-start-0" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>

        @if($products->count() > 0)
            <div class="row">
                @foreach($products as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 border-0 shadow-sm transition-hover">
                             <a href="{{ route('products.show', $product->slug) }}" class="position-relative overflow-hidden">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 220px; object-fit: cover; transition: transform 0.5s;">
                                @else
                                    <img src="https://via.placeholder.com/300x220" class="card-img-top" alt="No Image">
                                @endif
                                <div class="overlay d-flex align-items-center justify-content-center position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-25 opacity-0 hover-opacity-100 transition-opacity">
                                    <span class="btn btn-light rounded-circle shadow"><i class="fas fa-eye"></i></span>
                                </div>
                            </a>
                            <div class="card-body">
                                <h5 class="card-title text-truncate">
                                    <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none text-dark fw-bold hover-text-success">{{ $product->name }}</a>
                                </h5>
                                <p class="card-text text-danger fw-bold">{{ number_format($product->price) }} VNĐ</p>
                            </div>
                            <div class="card-footer bg-white border-top-0 d-grid pb-3">
                                <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-success rounded-pill"><i class="fas fa-cart-plus me-1"></i> Mua ngay</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $products->appends(request()->query())->links() }}
            </div>
        @else
            <div class="alert alert-info text-center py-5">
                <i class="fas fa-search fa-3x mb-3 text-muted"></i>
                <h4 class="alert-heading">Không tìm thấy sản phẩm!</h4>
                <p>Rất tiếc, chúng tôi không tìm thấy sản phẩm nào phù hợp với yêu cầu của bạn.</p>
                <a href="{{ route('products.index') }}" class="btn btn-success mt-2">Xem tất cả sản phẩm</a>
            </div>
        @endif
    </div>
</div>

<style>
    .hover-text-success:hover { color: var(--primary-color) !important; }
    .card-img-top:hover { transform: scale(1.05); }
    .overlay { opacity: 0; transition: opacity 0.3s; }
    .card:hover .overlay { opacity: 1; }
</style>
@endsection