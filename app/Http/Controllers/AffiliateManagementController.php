<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AffiliateManagementController extends Controller
{
    /**
     * Display a listing of affiliates.
     */
    public function index()
    {
        $affiliates = User::affiliates()
            ->withCount('sales')
            ->withSum(['sales as total_commission' => function($query) {
                $query->where('status', 'confirmed');
            }], 'commission_amount')
            ->latest()
            ->paginate(20);

        return Inertia::render('admin/affiliates/index', [
            'affiliates' => $affiliates,
        ]);
    }

    /**
     * Show the form for creating a new affiliate.
     */
    public function create()
    {
        return Inertia::render('admin/affiliates/create');
    }

    /**
     * Store a newly created affiliate.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $affiliate = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'affiliate',
            'is_active' => true,
        ]);

        return redirect()->route('affiliate-management.show', $affiliate)
            ->with('success', 'Affiliate created successfully.');
    }

    /**
     * Display the specified affiliate.
     */
    public function show(User $affiliateManagement)
    {
        $affiliate = $affiliateManagement->load(['sales.program', 'affiliateLinks.program', 'commissionPayouts']);
        
        return Inertia::render('admin/affiliates/show', [
            'affiliate' => $affiliate
        ]);
    }

    /**
     * Show the form for editing the specified affiliate.
     */
    public function edit(User $affiliateManagement)
    {
        return Inertia::render('admin/affiliates/edit', [
            'affiliate' => $affiliateManagement
        ]);
    }

    /**
     * Update the specified affiliate.
     */
    public function update(Request $request, User $affiliateManagement)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $affiliateManagement->id,
            'is_active' => 'boolean',
        ]);

        $affiliateManagement->update([
            'name' => $request->name,
            'email' => $request->email,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('affiliate-management.show', $affiliateManagement)
            ->with('success', 'Affiliate updated successfully.');
    }

    /**
     * Remove the specified affiliate.
     */
    public function destroy(User $affiliateManagement)
    {
        $affiliateManagement->delete();

        return redirect()->route('affiliate-management.index')
            ->with('success', 'Affiliate deleted successfully.');
    }
}