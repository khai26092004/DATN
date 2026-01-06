<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        // Thống kê cơ bản
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalCustomers = User::where('role', 'user')->count();

        // Doanh thu
        $todayRevenue = Order::whereDate('created_at', Carbon::today())
            ->where('status', '!=', 'cancelled')
            ->sum('total_price');

        $monthRevenue = Order::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->where('status', '!=', 'cancelled')
            ->sum('total_price');

        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total_price');

        // Đơn hàng mới cần xử lý
        $pendingOrdersCount = Order::where('status', 'pending')->count();

        // Đơn hàng mới nhất
        $latestOrders = Order::with('user')->latest()->take(5)->get();

        // --- Thống kê biểu đồ ---
        $startDate = $request->input('start_date', Carbon::now()->subDays(30)->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());

        $revenueStats = Order::selectRaw('DATE(created_at) as date, SUM(total_price) as total')
            ->where('status', '!=', 'cancelled')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date')
            ->toArray();

        // Fill missing dates
        $labels = [];
        $data = [];
        $period = \Carbon\CarbonPeriod::create($startDate, $endDate);

        foreach ($period as $date) {
            $formattedDate = $date->format('Y-m-d');
            $labels[] = $date->format('d/m/Y'); // Hiển thị đẹp hơn
            $data[] = $revenueStats[$formattedDate] ?? 0;
        }

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'totalCustomers',
            'todayRevenue',
            'monthRevenue',
            'totalRevenue',
            'pendingOrdersCount',
            'latestOrders',
            'labels',
            'data',
            'startDate',
            'endDate'
        ));
    }
}
