@extends('admin.layout')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Quản lý Khách hàng</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách Khách hàng</h6>
            <form class="d-flex" method="GET" action="{{ route('admin.customers.index') }}">
                <input class="form-control me-2" type="search" placeholder="Tìm kiếm..." name="search"
                    value="{{ request('search') }}">
                <button class="btn btn-outline-success" type="submit">Tìm</button>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Họ tên</th>
                            <th>Email</th>
                            <th>Ngày đăng ký</th>
                            <th>Số đơn hàng</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $customer)
                            <tr>
                                <td>{{ $customer->id }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $customer->orders ? $customer->orders->count() : 0 }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.customers.show', $customer->id) }}"
                                        class="btn btn-info btn-sm text-white">
                                        <i class="fas fa-eye"></i> Chi tiết
                                    </a>
                                    <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa khách hàng này? Tất cả dữ liệu liên quan có thể bị mất.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash-alt"></i> Xóa
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Không tìm thấy khách hàng nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $customers->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection