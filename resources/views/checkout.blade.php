@extends('layouts.app')

@section('title', 'Thanh toán - PlantShop')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 text-center mb-4">
            <h2 class="fw-bold text-uppercase border-bottom d-inline-block pb-2 border-success border-3">Thanh toán đơn hàng
            </h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-success text-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-shipping-fast me-2"></i>Thông tin giao hàng</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Họ tên người nhận</label>
                            <input type="text" class="form-control bg-light" value="{{ Auth::user()->name }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control bg-light" value="{{ Auth::user()->email }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control" required
                                placeholder="Nhập số điện thoại liên hệ" pattern="[0-9]{10,11}"
                                value="{{ old('phone', Auth::user()->phone) }}">
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Địa chỉ giao hàng <span class="text-danger">*</span></label>
                            <textarea name="shipping_address" class="form-control" rows="3" required
                                placeholder="Nhập số nhà, tên đường, phường/xã, quận/huyện, tỉnh/thành phố...">{{ old('shipping_address', Auth::user()->address) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Phương thức thanh toán</label>
                            <div class="border rounded p-3">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="payment_method" id="payment_cod"
                                        value="cod" checked onchange="togglePaymentDetails()">
                                    <label class="form-check-label d-flex align-items-center" for="payment_cod">
                                        <i class="fas fa-money-bill-wave text-success fs-5 me-2"></i>
                                        <div>
                                            <span class="fw-bold d-block">Thanh toán khi nhận hàng (COD)</span>
                                            <small class="text-muted">Bạn sẽ thanh toán tiền mặt cho shipper khi nhận được
                                                hàng.</small>
                                        </div>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="payment_bank"
                                        value="bank_transfer" onchange="togglePaymentDetails()">
                                    <label class="form-check-label d-flex align-items-center" for="payment_bank">
                                        <i class="fas fa-university text-primary fs-5 me-2"></i>
                                        <div>
                                            <span class="fw-bold d-block">Chuyển khoản ngân hàng</span>
                                            <small class="text-muted">Chuyển khoản qua ngân hàng trước khi giao
                                                hàng.</small>
                                        </div>
                                    </label>
                                </div>
                                <div id="bank-details" class="mt-3 p-3 bg-light rounded border border-primary d-none">
                                    <h6 class="fw-bold text-primary mb-2"><i class="fas fa-info-circle me-1"></i>Thông tin
                                        chuyển khoản</h6>
                                    <div class="text-center mb-2">
                                        <img src="{{ asset('images/anh-QR.jpg') }}" alt="QR Code Bank Transfer"
                                            style="max-width: 200px;" class="img-fluid border rounded">
                                    </div>
                                    <p class="mb-1 small"><strong>Ngân hàng:</strong> BIDV</p>
                                    <p class="mb-1 small"><strong>Số tài khoản:</strong> 4661360881</p>
                                    <p class="mb-1 small"><strong>Chủ tài khoản:</strong> Hoàng Văn Khải</p>
                                    <p class="mb-0 small"><strong>Nội dung:</strong> SĐT + Tên người nhận</p>
                                </div>
                            </div>
                        </div>

                        <script>
                            function togglePaymentDetails() {
                                var method = document.querySelector('input[name="payment_method"]:checked').value;
                                var bankDetails = document.getElementById('bank-details');
                                if (method === 'bank_transfer') {
                                    bankDetails.classList.remove('d-none');
                                } else {
                                    bankDetails.classList.add('d-none');
                                }
                            }
                        </script>

                        <button type="submit" class="btn btn-success w-100 btn-lg rounded-pill fw-bold shadow-sm mt-2">
                            Xác nhận đặt hàng <i class="fas fa-check-circle ms-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-5 mb-4">
            <div class="card shadow-sm border-0 h-100 position-sticky" style="top: 90px;">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 fw-bold text-success"><i class="fas fa-receipt me-2"></i>Đơn hàng của bạn</h5>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive mb-3">
                        <table class="table table-borderless">
                            <thead class="text-muted small border-bottom">
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th class="text-end">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0 @endphp
                                @foreach(session('cart', []) as $item)
                                    @php $total += $item['price'] * $item['quantity'] @endphp
                                    <tr class="border-bottom">
                                        <td class="py-3">
                                            <div class="fw-bold">{{ $item['name'] }}</div>
                                            <div class="small text-muted">SL: x {{ $item['quantity'] }}</div>
                                        </td>
                                        <td class="text-end py-3">{{ number_format($item['price'] * $item['quantity']) }} VNĐ
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Tạm tính:</span>
                        <span class="fw-bold">{{ number_format($total) }} VNĐ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="text-muted">Phí vận chuyển:</span>
                        <span class="text-success fw-bold">Miễn phí</span>
                    </div>

                    <div class="border-top pt-3 d-flex justify-content-between align-items-center">
                        <span class="fw-bold fs-5">Tổng cộng:</span>
                        <span class="fw-bold fs-4 text-danger">{{ number_format($total) }} VNĐ</span>
                    </div>

                    <div class="d-grid mt-4">
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary rounded-pill btn-sm"><i
                                class="fas fa-arrow-left me-2"></i> Quay lại giỏ hàng</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection