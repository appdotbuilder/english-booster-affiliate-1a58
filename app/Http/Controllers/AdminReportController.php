<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminReportController extends Controller
{
    /**
     * Display admin commission reports.
     */
    public function index()
    {
        // Get monthly sales data
        $monthlySales = Sale::where('status', 'confirmed')
            ->selectRaw('YEAR(sale_date) as year, MONTH(sale_date) as month, COUNT(*) as count, SUM(sale_amount) as total, SUM(commission_amount) as commissions')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->take(12)
            ->get();

        // Get affiliate performance
        $affiliatePerformance = User::affiliates()
            ->select('users.id', 'users.name', 'users.email')
            ->withCount(['sales as total_sales' => function($query) {
                $query->where('status', 'confirmed');
            }])
            ->withSum(['sales as total_commission' => function($query) {
                $query->where('status', 'confirmed');
            }], 'commission_amount')
            ->withSum(['sales as total_revenue' => function($query) {
                $query->where('status', 'confirmed');
            }], 'sale_amount')
            ->orderBy('total_commission', 'desc')
            ->get();

        return Inertia::render('admin/reports/index', [
            'monthlySales' => $monthlySales,
            'affiliatePerformance' => $affiliatePerformance,
        ]);
    }
}