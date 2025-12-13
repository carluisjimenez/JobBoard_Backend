<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobOfferController extends Controller
{

    public function create(Request $request)
    {
        $validated = $request->validate([
            'job_title'   => 'required|string|max:255',
            'description' => 'required|string',
            'location'    => 'required|string|max:255',
            'salary'      => 'required|numeric',
            'category'    => 'required|string|max:255',
        ]);

        $jobOffer = JobOffer::create([
            'job_title'   => $validated['job_title'],
            'description' => $validated['description'],
            'location'    => $validated['location'],
            'salary'      => $validated['salary'],
            'category'    => $validated['category'],
            'user_id'     => Auth::id(),
        ]);

        return response()->json([
            'message'   => 'Oferta de trabajo creada con éxito',
            'job_offer' => $jobOffer,
        ], 201);
    }


    public function index(Request $request)
    {
        $jobOffers = JobOffer::where('user_id', Auth::id())->get();
        return response()->json($jobOffers);
    }

    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'job_title'   => 'required|string|max:255',
            'description' => 'required|string',
            'location'    => 'required|string|max:255',
            'salary'      => 'required|numeric',
            'category'    => 'required|string|max:255',
        ]);


        $offer = JobOffer::findOrFail($id);


        $offer = JobOffer::findOrFail($id);


        if ($offer->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'No tienes permiso para editar esta oferta'
            ], 403);
        }

        $offer->update([
            'job_title'   => $validated['job_title'],
            'description' => $validated['description'],
            'location'    => $validated['location'],
            'salary'      => $validated['salary'],
            'category'    => $validated['category'],
        ]);

        return response()->json([
            'message'   => 'Oferta actualizada con éxito',
            'job_offer' => $offer,
        ], 200);
    }

    public function destroy($id)
    {
        $offer = JobOffer::findOrFail($id);

        if ($offer->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'No tienes permiso para eliminar esta oferta'
            ], 403);
        }

        $offer->delete();

        return response()->json([
            'message' => 'Oferta eliminada con éxito'
        ], 200);
    }

  
    public function all()
    {
        $offers = JobOffer::all();
        return response()->json($offers);
    }



    public function search(Request $request)
    {
        $validated = $request->validate([
            'location' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',

        ]);

        $query = JobOffer::query();


        if ($validated['location']) {
            $query->where('location', 'like', '%' . $validated['location'] . '%');
        }
        if ($validated['category']) {
            $query->where('category', 'like', '%' . $validated['category'] . '%');
        }



        $jobOffers = $query->get();

        return response()->json($jobOffers);
    }

}
