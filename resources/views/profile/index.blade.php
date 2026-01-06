@extends('layouts.app')

@section('title', 'Hồ sơ của tôi - PlantShop')

@section('content')
    <div class="row">
        <!-- Sidebar / Navigation can go here if needed -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-user-circle me-2"></i>Thông tin tài khoản</h5>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-3">
                            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-3">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Họ tên</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Số điện thoại</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}"
                                placeholder="Thêm số điện thoại">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Địa chỉ</label>
                            <textarea name="address" class="form-control" rows="2"
                                placeholder="Thêm địa chỉ giao hàng mặc định">{{ old('address', $user->address) }}</textarea>
                        </div>



                        <button type="submit" class="btn btn-success w-100 rounded-pill fw-bold shadow-sm">
                            <i class="fas fa-save me-2"></i> Lưu thay đổi
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-success"><i class="fas fa-history me-2"></i>Lịch sử đơn hàng</h5>
                </div>
                <div class="card-body p-0">
                    @if($orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="bg-light text-muted small text-uppercase">
                                    <tr>
                                        <th class="ps-4">Mã đơn</th>
                                        <th>Ngày đặt</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                        <th class="text-end pe-4">Chi tiết</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td class="ps-4 fw-bold">#{{ $order->id }}</td>
                                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                            <td class="fw-bold text-success">{{ number_format($order->total_price) }} đ</td>
                                            <td>
                                                @if($order->status == 'pending')
                                                    <span class="badge bg-warning text-dark rounded-pill">Chờ xử lý</span>
                                                @elseif($order->status == 'confirmed')
                                                    <span class="badge bg-info text-white rounded-pill">Đã xác nhận</span>
                                                @elseif($order->status == 'shipping')
                                                    <span class="badge bg-primary rounded-pill">Đang giao</span>
                                                @elseif($order->status == 'completed')
                                                    <span class="badge bg-success rounded-pill">Hoàn thành</span>
                                                @elseif($order->status == 'cancelled')
                                                    <span class="badge bg-danger rounded-pill">Đã hủy</span>
                                                @endif
                                            </td>
                                            <td class="text-end pe-4">
                                                <a href="{{ route('orders.show', $order) }}"
                                                    class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                    Xem
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-cart-2130356-1800917.png"
                                alt="Empty Orders" style="width: 200px; opacity: 0.5;">
                            <p class="text-muted mt-3">Bạn chưa có đơn hàng nào.</p>
                            <a href="{{ route('products.index') }}" class="btn btn-success rounded-pill px-4 shadow-sm">Mua sắm
                                ngay</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection