@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng - PlantShop')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Chi tiết đơn hàng #{{ $order->id }}</h2>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">Thông tin giao hàng</div>
                <div class="card-body">
                    <p><strong>Người nhận:</strong> {{ $order->user->name }}</p>
                    <p><strong>Số điện thoại:</strong> {{ $order->phone }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>
                    <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header bg-info text-white">Trạng thái đơn hàng</div>
                <div class="card-body d-flex align-items-center justify-content-center flex-column">
                    <h4 class="mb-3">
                        @if($order->status == 'pending')
                            <span class="badge bg-warning text-dark">Chờ xác nhận</span>
                        @elseif($order->status == 'confirmed')
                            <span class="badge bg-primary">Đã xác nhận</span>
                        @elseif($order->status == 'shipping')
                            <span class="badge bg-info text-dark">Đang giao hàng</span>
                        @elseif($order->status == 'completed')
                            <span class="badge bg-success">Hoàn thành</span>
                        @else
                            <span class="badge bg-danger">Đã hủy</span>
                        @endif
                    </h4>

                    @if($order->status == 'pending')
                        <form action="{{ route('orders.cancel', $order) }}" method="POST" class="mt-2"
                            onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?');">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-times me-1"></i> Hủy đơn hàng
                            </button>
                        </form>
                    @endif

                    <p class="text-muted text-center mt-3">Cảm ơn bạn đã mua hàng tại PlantShop!</p>

                    <div class="mt-3 text-center border-top pt-3 w-100">
                        <p class="mb-1"><strong>Phương thức thanh toán:</strong>
                            @if($order->payment_method == 'bank_transfer')
                                <span class="badge bg-primary">Chuyển khoản</span>
                            @else
                                <span class="badge bg-success">COD</span>
                            @endif
                        </p>

                        @if($order->payment_method == 'bank_transfer' && $order->status == 'pending')
                            <div class="alert alert-info mt-2 text-start small">
                                <h6 class="fw-bold"><i class="fas fa-info-circle me-1"></i>Thông tin chuyển khoản:</h6>
                                <div class="text-center mb-2">
                                    <img src="{{ asset('images/anh-QR.jpg') }}" alt="QR Code Bank Transfer"
                                        style="max-width: 150px;" class="img-fluid border rounded">
                                </div>
                                <p class="mb-1"><strong>Ngân hàng:</strong>BIDV</p>
                                <p class="mb-1"><strong>STK:</strong>4661360881</p>
                                <p class="mb-1"><strong>Chủ TK:</strong>Hoàng Văn Khải</p>
                                <p class="mb-0"><strong>Nội dung:</strong> SĐT + Tên người nhận</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h4 class="mt-4">Sản phẩm đã đặt</h4>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Sản phẩm</th>
                    <th>Hình ảnh</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>
                            @if($item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" width="50">
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ number_format($item->price) }} VNĐ</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->price * $item->quantity) }} VNĐ</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-end fw-bold">Tổng cộng:</td>
                    <td class="fw-bold text-danger">{{ number_format($order->total_price) }} VNĐ</td>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection