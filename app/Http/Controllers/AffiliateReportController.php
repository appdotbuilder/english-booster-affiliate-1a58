<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AffiliateReportController extends Controller
{
    /**
     * Display commission reports for the authenticated affiliate.
     */
    public function index()
    {
        $user = Auth::user();

        // Get sales data with filters
        $sales = $user->sales()
            ->with('program')
            ->latest('sale_date')
            ->paginate(20);

        // Get monthly commission data for chart
        $monthlyCommissions = $user->sales()
            ->where('status', 'confirmed')
            ->selectRaw('YEAR(sale_date) as year, MONTH(sale_date) as month, SUM(commission_amount) as total')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->take(12)
            ->get();

        return Inertia::render('affiliate/reports', [
            'sales' => $sales,
            'monthlyCommissions' => $monthlyCommissions,
        ]);
    }
}