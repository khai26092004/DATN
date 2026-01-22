@extends('admin.layout')

@section('content')
    <h2>Thêm sản phẩm mới</h2>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary mb-3">Quay lại</a>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-8">
                <div class="mb-3">
                    <label class="form-label">Tên sản phẩm</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Đặc điểm</label>
                    <textarea name="characteristics" class="form-control" rows="3">{{ old('characteristics') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ánh sáng</label>
                    <textarea name="light" class="form-control" rows="2">{{ old('light') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tưới nước</label>
                    <textarea name="watering" class="form-control" rows="2">{{ old('watering') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Công dụng</label>
                    <textarea name="usage" class="form-control" rows="3">{{ old('usage') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ý nghĩa</label>
                    <textarea name="meaning" class="form-control" rows="3">{{ old('meaning') }}</textarea>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Danh mục (Nhấn Ctrl để chọn nhiều)</label>
                    <select name="categories[]" class="form-control" multiple required style="height: 150px;">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ in_array($category->id, old('categories', [])) ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Giá</label>
                    <input type="number" name="price" class="form-control" value="{{ old('price') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Số lượng kho</label>
                    <input type="number" name="stock_quantity" class="form-control" value="{{ old('stock_quantity', 0) }}"
                        required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Hình ảnh</label>
                    <input type="file" name="image" class="form-control">
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-success">Lưu sản phẩm</button>
    </form>
@endsection