@extends('admin.layout')

@section('content')
    <div class="row mb-4 align-items-end">
        <div class="col-md-6">
            <h1 class="h2">Tổng quan</h1>
        </div>
        <div class="col-md-6">
            <form action="{{ route('admin.dashboard') }}" method="GET"
                class="d-flex justify-content-end align-items-end gap-2">
                <div>
                    <label class="form-label small text-muted mb-1">Từ ngày</label>
                    <input type="date" name="start_date" class="form-control form-control-sm" value="{{ $startDate }}">
                </div>
                <div>
                    <label class="form-label small text-muted mb-1">Đến ngày</label>
                    <input type="date" name="end_date" class="form-control form-control-sm" value="{{ $endDate }}">
                </div>
                <button type="submit" class="btn btn-primary btn-sm mb-0">
                    <i class="fas fa-filter"></i> Lọc
                </button>
            </form>
        </div>
    </div>



    <!-- Stats Cards -->
    <div class="row">
        <!-- Doanh thu hôm nay -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2 border-0 border-start border-4 border-primary">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Doanh thu (Hôm nay)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($todayRevenue) }} VNĐ</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300 text-muted"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Doanh thu tháng này -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2 border-0 border-start border-4 border-success">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Doanh thu (Tháng này)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($monthRevenue) }} VNĐ</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300 text-muted"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tổng đơn hàng -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2 border-0 border-start border-4 border-info">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Tổng đơn hàng</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalOrders }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300 text-muted"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Khách hàng -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2 border-0 border-start border-4 border-warning">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Khách hàng</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalCustomers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300 text-muted"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Đơn hàng cần xử lý -->
        <div class="col-md-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-header bg-warning text-dark">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-exclamation-circle me-1"></i> Cần xử lý</h6>
                </div>
                <div class="card-body text-center">
                    <h3 class="display-4 fw-bold text-warning">{{ $pendingOrdersCount }}</h3>
                    <p class="text-muted">Đơn hàng đang chờ xác nhận</p>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-warning btn-sm">Xem tất cả</a>
                </div>
            </div>
        </div>

        <!-- Đơn hàng mới nhất -->
        <div class="col-md-8 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Đơn hàng mới nhất</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Mã ĐH</th>
                                    <th>Khách hàng</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày đặt</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestOrders as $order)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $order->id) }}">
                                                #{{ $order->id }}
                                            </a>
                                        </td>
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
                                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Chưa có đơn hàng nào.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Row -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow h-100">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Biểu đồ doanh thu</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myAreaChart" style="height: 300px; width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var ctx = document.getElementById("myAreaChart");
            var myLineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($labels) !!},
                    datasets: [{
                        label: "Doanh thu",
                        lineTension: 0.3,
                        backgroundColor: "rgba(78, 115, 223, 0.05)",
                        borderColor: "rgba(78, 115, 223, 1)",
                        pointRadius: 3,
                        pointBackgroundColor: "rgba(78, 115, 223, 1)",
                        pointBorderColor: "rgba(78, 115, 223, 1)",
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                        pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                        data: {!! json_encode($data) !!},
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            left: 10,
                            right: 25,
                            top: 25,
                            bottom: 0
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                        },
                        y: {
                            ticks: {
                                callback: function (value, index, values) {
                                    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value);
                                }
                            },
                            grid: {
                                color: "rgb(234, 236, 244)",
                                zeroLineColor: "rgb(234, 236, 244)",
                                drawBorder: false,
                                borderDash: [2],
                                zeroLineBorderDash: [2]
                            }
                        },
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    var label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection