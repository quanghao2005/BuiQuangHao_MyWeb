<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Customer;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total_amount');
        $totalProducts = Product::count();
        $totalUsers = User::count(); // Count all registered users

        $recentOrders = Order::with('customer')->orderBy('created_at', 'desc')->take(50)->get();

        return view('admin.dashboard', compact('totalOrders', 'totalRevenue', 'totalProducts', 'totalUsers', 'recentOrders'));
    }

    public function stats()
    {
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total_amount');
        $totalProducts = Product::count();
        $totalUsers = User::count();

        $recentOrders = Order::with('customer')->orderBy('created_at', 'desc')->take(50)->get();

        $html = view('admin._partials.recent_orders_table', compact('recentOrders'))->render();

        return response()->json([
            'totalOrders' => $totalOrders,
            'totalRevenue' => number_format($totalRevenue, 0, ',', '.') . 'đ',
            'totalProducts' => $totalProducts,
            'totalUsers' => $totalUsers,
            'tableHtml' => $html
        ]);
    }

    public function chartData(Request $request)
    {
        $period = $request->get('period', 'week');
        $now = Carbon::now();
        
        if ($period == 'day') {
            $startDate = $now->copy()->startOfDay();
        } elseif ($period == 'month') {
            $startDate = $now->copy()->startOfMonth();
        } elseif ($period == 'quarter') {
            $startDate = $now->copy()->startOfQuarter();
        } elseif ($period == 'year') {
            $startDate = $now->copy()->startOfYear();
        } else {
            $startDate = $now->copy()->startOfWeek();
        }

        $orders = Order::where('status', '!=', 'cancelled')
                       ->where('created_at', '>=', $startDate)
                       ->get();

        $labels = [];
        $data = [];

        if ($period == 'day') {
            for ($i = 0; $i < 24; $i++) {
                $labels[] = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00';
                $data[] = $orders->filter(function($order) use ($i) {
                    return Carbon::parse($order->created_at)->hour == $i;
                })->sum('total_amount');
            }
        } elseif ($period == 'year') {
            for ($i = 1; $i <= 12; $i++) {
                $labels[] = 'Tháng ' . $i;
                $data[] = $orders->filter(function($order) use ($i) {
                    return Carbon::parse($order->created_at)->month == $i;
                })->sum('total_amount');
            }
        } elseif ($period == 'quarter') {
            $startMonth = $now->copy()->startOfQuarter()->month;
            for ($i = 0; $i < 3; $i++) {
                $m = $startMonth + $i;
                $labels[] = 'Tháng ' . $m;
                $data[] = $orders->filter(function($order) use ($m) {
                    return Carbon::parse($order->created_at)->month == $m;
                })->sum('total_amount');
            }
        } elseif ($period == 'month') {
            $daysInMonth = $now->daysInMonth;
            for ($i = 1; $i <= $daysInMonth; $i++) {
                $labels[] = 'Ngày ' . $i;
                $data[] = $orders->filter(function($order) use ($i) {
                    return Carbon::parse($order->created_at)->day == $i;
                })->sum('total_amount');
            }
        } else { // week
            $days = ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'CN'];
            foreach ($days as $index => $dayName) {
                $labels[] = $dayName;
                $data[] = $orders->filter(function($order) use ($index) {
                    // dayOfWeekIso returns 1 for Monday, 7 for Sunday
                    return Carbon::parse($order->created_at)->dayOfWeekIso == ($index + 1);
                })->sum('total_amount');
            }
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data
        ]);
    }

    public function sidebarStats()
    {
        $pendingOrders = Order::where('status', 0)->count();
        return response()->json([
            'pendingOrders' => $pendingOrders
        ]);
    }
}
