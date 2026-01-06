@extends('admin.layout')

@section('content')
    <h2>Cập nhật danh mục</h2>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary mb-3">Quay lại</a>

    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Tên danh mục</label>
            <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea name="description" class="form-control" rows="3">{{ $category->description }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
@endsection