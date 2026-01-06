@extends('layouts.app')

@section('title', 'Liên hệ - PlantShop')

@section('content')
    <div class="row">
        <div class="col-md-12 text-center mb-5">
            <h1 class="display-4 fw-bold text-success">Liên hệ với chúng tôi</h1>
            <p class="lead text-muted">Chúng tôi luôn sẵn sàng lắng nghe bạn</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body p-4">
                    <h3 class="mb-4">Thông tin liên lạc</h3>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <i class="fas fa-map-marker-alt text-success me-3 fa-lg"></i>
                            <strong>Địa chỉ:</strong> Số 123, Đường Cây Xanh, Quận Hoàn Kiếm, Hà Nội
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-phone text-success me-3 fa-lg"></i>
                            <strong>Điện thoại:</strong> 0912 345 678
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-envelope text-success me-3 fa-lg"></i>
                            <strong>Email:</strong> contact@plantshop.vn
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-clock text-success me-3 fa-lg"></i>
                            <strong>Giờ mở cửa:</strong> 8:00 - 20:00 (Hàng ngày)
                        </li>
                    </ul>
                    <div class="mt-4">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.093226685458!2d105.84996967599955!3d21.028955987771746!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab953357c995%3A0x860e608538356247!2zSOG7kyBHxrDGoW0!5e0!3m2!1svi!2s!4v1703666000000!5m2!1svi!2s"
                            width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body p-4">
                    <h3 class="mb-4">Gửi tin nhắn</h3>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Họ và tên</label>
                            <input type="text" name="name" class="form-control" placeholder="Nhập tên của bạn" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Nhập email của bạn" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Chủ đề</label>
                            <input type="text" name="subject" class="form-control" placeholder="Bạn cần hỗ trợ gì?"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nội dung</label>
                            <textarea name="message" class="form-control" rows="5" placeholder="Nhập nội dung tin nhắn..."
                                required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Gửi tin nhắn</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection