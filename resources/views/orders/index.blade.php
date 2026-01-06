@extends('layouts.app')

@section('title', 'Lịch sử đơn hàng - PlantShop')

@section('content')
    <h2 class="mb-4">Lịch sử đơn hàng của bạn</h2>

    @if($orders->count() > 0)
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Mã ĐH</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ number_format($order->total_price) }} VNĐ</td>
                        <td>
                            @if($order->status == 'pending')
                                <span class="badge bg-warning text-dark">Chờ xác nhận</span>
                            @elseif($order->status == 'confirmed')
                                <span class="badge bg-primary">Đã xác nhận</span>
                            @elseif($order->status == 'shipping')
                                <span class="badge bg-info text-dark">Đang giao</span>
                            @elseif($order->status == 'completed')
                                <span class="badge bg-success">Hoàn thành</span>
                            @else
                                <span class="badge bg-danger">Đã hủy</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-info btn-sm text-white">Xem chi tiết</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $orders->links() }}
    @else
        <div class="alert alert-info">Bạn chưa có đơn hàng nào. <a href="{{ route('products.index') }}">Mua sắm ngay!</a></div>
    @endif
@endsection