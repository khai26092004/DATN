@extends('layouts.app')

@section('title', 'Giới thiệu - PlantShop')

@section('content')
    <div class="row">
        <div class="col-md-12 text-center mb-5">
            <h1 class="display-4 fw-bold text-success">Về PlantShop</h1>
            <p class="lead text-muted">Mang thiên nhiên đến ngôi nhà của bạn</p>
        </div>
    </div>

    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <img src="https://images.unsplash.com/photo-1463936575829-25148e1db1b8?auto=format&fit=crop&w=800&q=80"
                class="img-fluid rounded shadow" alt="Vườn cây">
        </div>
        <div class="col-md-6">
            <h3 class="mb-3">Câu chuyện của chúng tôi</h3>
            <p>PlantShop được thành lập với niềm đam mê mãnh liệt đối với thiên nhiên và cây cảnh. Chúng tôi tin rằng mỗi
                chậu cây không chỉ là một vật trang trí, mà còn là một người bạn mang lại sức sống, sự bình yên và không khí
                trong lành cho không gian sống của bạn.</p>
            <p>Từ những hạt giống nhỏ bé, chúng tôi chăm sóc và nuôi dưỡng từng cái cây với sự tỉ mỉ và tình yêu thương, để
                đảm bảo rằng khi đến tay bạn, chúng luôn khỏe mạnh và tươi tốt nhất.</p>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-md-4 text-center">
            <div class="p-4">
                <i class="fas fa-leaf fa-3x text-success mb-3"></i>
                <h4>Sản phẩm chất lượng</h4>
                <p>Cây được tuyển chọn kỹ lưỡng, khỏe mạnh và không sâu bệnh.</p>
            </div>
        </div>
        <div class="col-md-4 text-center">
            <div class="p-4">
                <i class="fas fa-truck fa-3x text-success mb-3"></i>
                <h4>Giao hàng cẩn thận</h4>
                <p>Đóng gói chuyên nghiệp, đảm bảo cây an toàn khi vận chuyển.</p>
            </div>
        </div>
        <div class="col-md-4 text-center">
            <div class="p-4">
                <i class="fas fa-headset fa-3x text-success mb-3"></i>
                <h4>Tư vấn nhiệt tình</h4>
                <p>Đội ngũ am hiểu về cây cảnh sẵn sàng hỗ trợ bạn chăm sóc cây.</p>
            </div>
        </div>
    </div>
@endsection