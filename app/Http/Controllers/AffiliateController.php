<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AffiliateLink;
use App\Models\Program;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AffiliateController extends Controller
{
    /**
     * Display the affiliate dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user->isAffiliate()) {
            return redirect()->route('admin.dashboard');
        }

        // Get affiliate statistics
        $totalSales = $user->sales()->where('status', 'confirmed')->count();
        $totalCommission = $user->getTotalCommissionAttribute();
        $pendingCommission = $user->getPendingCommissionAttribute();
        $totalClicks = $user->affiliateLinks()->sum('clicks');

        // Get recent sales
        $recentSales = $user->sales()
            ->with('program')
            ->latest('sale_date')
            ->take(5)
            ->get();

        // Get affiliate links with program information
        $affiliateLinks = $user->affiliateLinks()
            ->with('program')
            ->latest()
            ->get();

        // Get programs available for linking
        $availablePrograms = Program::active()
            ->whereNotIn('id', $affiliateLinks->pluck('program_id'))
            ->get();

        return Inertia::render('affiliate/dashboard', [
            'stats' => [
                'totalSales' => $totalSales,
                'totalCommission' => $totalCommission,
                'pendingCommission' => $pendingCommission,
                'totalClicks' => $totalClicks,
            ],
            'recentSales' => $recentSales,
            'affiliateLinks' => $affiliateLinks,
            'availablePrograms' => $availablePrograms,
        ]);
    }

    /**
     * Create a new affiliate link.
     */
    public function store(Request $request)
    {
        $request->validate([
            'program_id' => 'required|exists:programs,id',
        ]);

        $user = Auth::user();

        // Check if link already exists
        $existingLink = AffiliateLink::where('user_id', $user->id)
            ->where('program_id', $request->program_id)
            ->first();

        if ($existingLink) {
            return back()->with('error', 'You already have a link for this program.');
        }

        // Create new affiliate link
        AffiliateLink::create([
            'user_id' => $user->id,
            'program_id' => $request->program_id,
        ]);

        return back()->with('success', 'Affiliate link created successfully!');
    }


}