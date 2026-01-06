@extends('layouts.app')

@section('title', 'Giỏ hàng - PlantShop')

@section('scripts')
    <script type="text/javascript">
        $(".cart_update").change(function (e) {
            e.preventDefault();
            var ele = $(this);
            $.ajax({
                url: '{{ route('cart.update') }}',
                method: "patch",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: ele.parents("tr").attr("data-id"),
                    quantity: ele.parents("tr").find(".quantity").val()
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        });

        $(".cart_remove").click(function (e) {
            e.preventDefault();
            var ele = $(this);
            if (confirm("Bạn có chắc muốn xóa sản phẩm này?")) {
                $.ajax({
                    url: '{{ route('cart.remove') }}',
                    method: "DELETE",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: ele.parents("tr").attr("data-id")
                    },
                    success: function (response) {
                        window.location.reload();
                    }
                });
            }
        });
    </script>
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h2 class="fw-bold text-uppercase border-bottom d-inline-block pb-2 border-success border-3">Giỏ hàng của bạn
            </h2>
        </div>
    </div>

    @if(session('cart'))
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light text-muted small text-uppercase">
                                    <tr>
                                        <th scope="col" class="ps-4 py-3" style="width:50%">Sản phẩm</th>
                                        <th scope="col" class="py-3" style="width:15%">Giá</th>
                                        <th scope="col" class="py-3" style="width:15%">Số lượng</th>
                                        <th scope="col" class="py-3 text-center" style="width:15%">Thành tiền</th>
                                        <th scope="col" class="pe-4 py-3 text-end" style="width:5%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total = 0 @endphp
                                    @foreach(session('cart') as $id => $details)
                                        @php $total += $details['price'] * $details['quantity'] @endphp
                                        <tr data-id="{{ $id }}" class="border-bottom">
                                            <td class="ps-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    @if($details['image'])
                                                        <img src="{{ asset('storage/' . $details['image']) }}"
                                                            class="rounded me-3 border" width="70" height="70"
                                                            style="object-fit: cover;">
                                                    @else
                                                        <img src="https://via.placeholder.com/70" class="rounded me-3" width="70" />
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-0 fw-bold">{{ $details['name'] }}</h6>
                                                        <small class="text-muted">Mã SP: #{{ $id }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-muted fw-bold">{{ number_format($details['price']) }}</td>
                                            <td>
                                                <input type="number" value="{{ $details['quantity'] }}"
                                                    class="form-control form-control-sm text-center quantity cart_update"
                                                    style="width: 70px;" min="1" />
                                            </td>
                                            <td class="text-center text-success fw-bold">
                                                {{ number_format($details['price'] * $details['quantity']) }}</td>
                                            <td class="text-end pe-4">
                                                <button class="btn btn-link text-danger p-0 cart_remove" title="Xóa"><i
                                                        class="fas fa-trash-alt"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary rounded-pill px-4"><i
                            class="fas fa-arrow-left me-2"></i> Tiếp tục mua sắm</a>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm border-0 sticky-top" style="top: 80px;">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold">Tổng đơn hàng</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Tạm tính:</span>
                            <span class="fw-bold">{{ number_format($total) }} VNĐ</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="text-muted">Phí vận chuyển:</span>
                            <span class="text-success">Miễn phí</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold fs-5">Tổng cộng:</span>
                            <span class="fw-bold fs-5 text-success">{{ number_format($total) }} VNĐ</span>
                        </div>
                        <div class="d-grid">
                            <a href="{{ route('checkout.index') }}"
                                class="btn btn-success btn-lg rounded-pill fw-bold shadow-sm">Thanh toán ngay <i
                                    class="fas fa-arrow-right ms-2"></i></a>
                        </div>
                        <div class="mt-3 text-center small text-muted">
                            <i class="fas fa-shield-alt me-1"></i> Bảo mật thanh toán 100%
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <img src="https://cdn-icons-png.flaticon.com/512/11329/11329060.png" alt="Empty Cart"
                style="width: 150px; opacity: 0.5;">
            <h4 class="mt-4 text-muted">Giỏ hàng của bạn đang trống!</h4>
            <p class="text-muted mb-4">Hãy thêm những chậu cây xinh xắn vào không gian của bạn nhé.</p>
            <a href="{{ route('products.index') }}" class="btn btn-success rounded-pill px-5 shadow">Mua sắm ngay</a>
        </div>
    @endif
@endsection