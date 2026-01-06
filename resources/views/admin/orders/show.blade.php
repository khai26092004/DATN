@extends('admin.layout')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h2>Chi tiết đơn hàng #{{ $order->id }}</h2>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Quay lại</a>
    </div>

    <div class="row mt-4">
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-header bg-primary text-white">Thông tin khách hàng</div>
                <div class="card-body">
                    <p><strong>Họ tên:</strong> {{ $order->user->name }}</p>
                    <p><strong>Email:</strong> {{ $order->user->email }}</p>
                    <p><strong>SĐT:</strong> {{ $order->phone }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-header bg-info text-white">Trạng thái đơn hàng</div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Cập nhật trạng thái:</label>
                            <select name="status" class="form-select">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xác nhận
                                </option>
                                <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Đã xác nhận
                                </option>
                                <option value="shipping" {{ $order->status == 'shipping' ? 'selected' : '' }}>Đang giao hàng
                                </option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Hoàn thành
                                </option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy
                                </option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <h4 class="mt-3">Danh sách sản phẩm</h4>
    <table class="table table-bordered">
        <thead>
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
@endsection