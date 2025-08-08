<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AffiliateLink;
use App\Models\Program;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AffiliateTrackingController extends Controller
{
    /**
     * Handle affiliate link tracking.
     */
    public function show(Request $request, $trackingCode, $programId)
    {
        $affiliateLink = AffiliateLink::where('tracking_code', $trackingCode)
            ->where('program_id', $programId)
            ->first();

        if ($affiliateLink) {
            $affiliateLink->recordClick();
        }

        $program = Program::find($programId);
        
        if ($program) {
            return Inertia::render('program-details', [
                'program' => $program,
                'trackingCode' => $trackingCode,
            ]);
        }

        return redirect()->route('home');
    }
}