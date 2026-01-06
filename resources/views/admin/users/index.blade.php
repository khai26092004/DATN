@extends('admin.layout')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Quản lý Quản trị viên</h1>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm Admin mới
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách Admin</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Họ tên</th>
                            <th>Email</th>
                            <th>Ngày tạo</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($admins as $admin)
                            <tr>
                                <td>{{ $admin->id }}</td>
                                <td>
                                    {{ $admin->name }}
                                    @if(auth()->id() == $admin->id)
                                        <span class="badge bg-success ms-1">Bạn</span>
                                    @endif
                                </td>
                                <td>{{ $admin->email }}</td>
                                <td>{{ $admin->created_at->format('d/m/Y') }}</td>
                                <td>
                                    @if(auth()->id() != $admin->id)
                                        <form action="{{ route('admin.users.destroy', $admin->id) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa quyền quản trị viên này?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash-alt"></i> Xóa
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-secondary btn-sm" disabled>Xóa</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection