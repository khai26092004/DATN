@extends('admin.layout')

@section('content')
    <h2>Thêm danh mục mới</h2>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary mb-3">Quay lại</a>

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Tên danh mục</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Lưu danh mục</button>
    </form>
@endsection