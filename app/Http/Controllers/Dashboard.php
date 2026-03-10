<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Material;
use App\Models\Orders;
use App\Models\Quiz;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class Dashboard extends Controller
{
    public function ecashow()
    {
        $totalCustomers = Customer::count();
        $totalRevenue   = Orders::where('status', 'paid')->sum('total_price');
        $totalOrders    = Orders::count();
        $totalMaterials = Material::where('is_active', true)->count();

        $recentOrders = Orders::with('service')->latest()->take(10)->get();
        $recentActivities = Activity::with('causer')->latest()->take(10)->get();

        $chartData = Orders::where('status', 'paid')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $chartLabels = $chartData->pluck('date')->map(fn($d) => Carbon::parse($d)->format('d M'));
        $chartValues = $chartData->pluck('total');

        return view('dashboard', compact(
            'totalCustomers',
            'totalRevenue',
            'totalOrders',
            'totalMaterials',
            'recentOrders',
            'recentActivities',
            'chartLabels',
            'chartValues'
        ));
    }
}
