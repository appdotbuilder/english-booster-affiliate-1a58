<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CommissionPayout;
use App\Models\Program;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user->isAdmin()) {
            return redirect()->route('affiliate.dashboard');
        }

        // Get dashboard statistics
        $totalAffiliates = User::affiliates()->count();
        $totalSales = Sale::where('status', 'confirmed')->sum('sale_amount');
        $totalCommissions = Sale::where('status', 'confirmed')->sum('commission_amount');
        $pendingPayouts = CommissionPayout::where('status', 'pending')->sum('amount');

        // Get recent sales
        $recentSales = Sale::with(['affiliate', 'program'])
            ->latest('sale_date')
            ->take(10)
            ->get();

        // Get top performing affiliates
        $topAffiliates = User::affiliates()
            ->withSum(['sales as total_sales' => function($query) {
                $query->where('status', 'confirmed');
            }], 'commission_amount')
            ->orderBy('total_sales', 'desc')
            ->take(5)
            ->get();

        // Get sales by program
        $salesByProgram = Sale::where('status', 'confirmed')
            ->select('programs.name', DB::raw('COUNT(*) as count'), DB::raw('SUM(sale_amount) as total'))
            ->join('programs', 'sales.program_id', '=', 'programs.id')
            ->groupBy('programs.id', 'programs.name')
            ->orderBy('total', 'desc')
            ->get();

        return Inertia::render('admin/dashboard', [
            'stats' => [
                'totalAffiliates' => $totalAffiliates,
                'totalSales' => $totalSales,
                'totalCommissions' => $totalCommissions,
                'pendingPayouts' => $pendingPayouts,
            ],
            'recentSales' => $recentSales,
            'topAffiliates' => $topAffiliates,
            'salesByProgram' => $salesByProgram,
        ]);
    }
}