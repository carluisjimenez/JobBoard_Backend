<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class JobApplicationController extends Controller
{
    public function index()
    {
        $apps = JobApplication::with('jobOffer')
            ->where('user_id', Auth::id())
            ->get();

        return response()->json($apps);
    }

    public function store(Request $request)
    {

        $request->validate([
            'job_offer_id' => 'required|exists:job_offers,id',
            'message'      => 'nullable|string|max:500',
        ]);

        try {

            $exists = JobApplication::where('user_id', Auth::id())
                ->where('job_offer_id', $request->job_offer_id)
                ->exists();

            if ($exists) {
                return response()->json([
                    'message' => 'Ya te has postulado a esta oferta'
                ], 409);
            }


            $app = JobApplication::create([
                'user_id'      => Auth::id(),
                'job_offer_id' => $request->job_offer_id,
                'message'      => $request->message,
                'status'       => 'pendiente',
            ]);

            return response()->json([
                'message'     => 'Postulación enviada con éxito',
                'application' => $app->load('jobOffer'),
            ], 201);

        } catch (QueryException $e) {

            return response()->json([
                'error'   => 'QueryException',
                'details' => $e->getMessage(),
            ], 500);
        } catch (\Throwable $e) {
            return response()->json([
                'error'   => 'Exception',
                'details' => $e->getMessage(),
            ], 500);
        }
    }


    public function destroy($id)
    {
        $app = JobApplication::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $app->delete();

        return response()->json([
            'message' => 'Postulación eliminada correctamente'
        ]);
    }
}
