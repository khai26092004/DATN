@extends('admin.layout')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Chi tiết Khách hàng: {{ $customer->name }}</h1>
        <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="row">
        <!-- Customer Info -->
        <div class="col-md-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-user mb-1"></i> Thông tin cá nhân</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3 text-center">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($customer->name) }}&background=random&size=128"
                            class="rounded-circle mb-3" alt="{{ $customer->name }}">
                        <h4>{{ $customer->name }}</h4>
                        <p class="text-muted">{{ $customer->email }}</p>
                    </div>
                    <hr>
                    <div class="mb-2"><strong>ID:</strong> #{{ $customer->id }}</div>
                    <div class="mb-2"><strong>Ngày đăng ký:</strong> {{ $customer->created_at->format('d/m/Y H:i') }}</div>
                    <div class="mb-2"><strong>Tổng đơn hàng:</strong> {{ $customer->orders->count() }}</div>
                </div>
            </div>
        </div>

        <!-- Order History -->
        <div class="col-md-8 mb-4">
            <div class="card shadow h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-history mb-1"></i> Lịch sử đơn hàng</h5>
                </div>
                <div class="card-body">
                    @if($customer->orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Mã đơn</th>
                                        <th>Ngày đặt</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                        <th>Chi tiết</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customer->orders as $order)
                                        <tr>
                                            <td>#{{ $order->id }}</td>
                                            <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                            <td class="fw-bold">{{ number_format($order->total_amount) }} VNĐ</td>
                                            <td>
                                                @if($order->status == 'pending')
                                                    <span class="badge bg-warning text-dark">Chờ xử lý</span>
                                                @elseif($order->status == 'confirmed')
                                                    <span class="badge bg-primary">Đã xác nhận</span>
                                                @elseif($order->status == 'shipping')
                                                    <span class="badge bg-info text-dark">Đang giao</span>
                                                @elseif($order->status == 'completed')
                                                    <span class="badge bg-success">Hoàn thành</span>
                                                @elseif($order->status == 'cancelled')
                                                    <span class="badge bg-danger">Đã hủy</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info py-4 text-center">
                            <i class="fas fa-shopping-basket fa-2x mb-3 text-muted"></i>
                            <p class="mb-0">Khách hàng này chưa có đơn hàng nào.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection