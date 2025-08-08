<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminSaleController extends Controller
{
    /**
     * Display a listing of sales.
     */
    public function index()
    {
        $sales = Sale::with(['affiliate', 'program'])
            ->latest('sale_date')
            ->paginate(20);

        return Inertia::render('admin/sales/index', [
            'sales' => $sales,
        ]);
    }

    /**
     * Display the specified sale.
     */
    public function show(Sale $adminSale)
    {
        $sale = $adminSale->load(['affiliate', 'program']);
        
        return Inertia::render('admin/sales/show', [
            'sale' => $sale
        ]);
    }

    /**
     * Update the specified sale status.
     */
    public function update(Request $request, Sale $adminSale)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $adminSale->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Sale status updated successfully.');
    }
}