@extends('admin.layout')

@section('content')
    <h2>Quản lý Đơn hàng</h2>

    <div class="card mb-3">
        <div class="card-body">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Tìm theo Mã ĐH, Tên khách hoặc SĐT"
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">-- Tất cả trạng thái --</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Đã xác nhận
                        </option>
                        <option value="shipping" {{ request('status') == 'shipping' ? 'selected' : '' }}>Đang giao</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-1"></i> Tìm kiếm</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary w-100"><i
                            class="fas fa-undo me-1"></i> Đặt lại</a>
                </div>
            </form>
        </div>
    </div>

    <table class="table table-bordered table-striped mt-3">
        <thead class="table-dark">
            <tr>
                <th>Mã ĐH</th>
                <th>Khách hàng</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Ngày đặt</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->user->name }}</td>
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
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-info btn-sm text-white"><i
                                class="fas fa-eye"></i></a>
                        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $orders->withQueryString()->links() }}
@endsection