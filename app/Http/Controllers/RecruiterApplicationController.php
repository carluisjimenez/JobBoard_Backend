<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobOffer;
use Illuminate\Http\Request;

class RecruiterApplicationController extends Controller
{
    public function index($offerId)
    {
        $offer = JobOffer::findOrFail($offerId);
        $applications = JobApplication::with('user')
            ->where('job_offer_id', $offer->id)
            ->get();
        return response()->json($applications);
    }

    public function approve($applicationId)
    {
        try {
            $app = JobApplication::with('user', 'jobOffer')->findOrFail($applicationId);
            $app->status = 'aceptada';
            $app->save();

            return response()->json([
                'message'     => 'Postulación aprobada.',
                'application' => $app
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
}
